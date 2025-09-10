<?php

namespace App\Http\Controllers;

use App\Services\InterfaceService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class InterfaceController extends Controller
{
    protected InterfaceService $interfaceService;

    public function __construct(InterfaceService $interfaceService)
    {
        $this->interfaceService = $interfaceService;
    }

    /**
     * Display the main interface page with destinations and tours
     */
    public function main(Request $request): View
    {
        // Set locale if provided
        $locale = $request->get('locale', 'en');
        if (in_array($locale, ['en', 'de', 'fr'])) {
            app()->setLocale($locale);
        }

        $destinations = $this->interfaceService->getDestinationsWithLatestTours();
        $popularTours = $this->interfaceService->getPopularTours();
        // $testimonials = $this->interfaceService->getFeaturedTestimonials();

        return view('interface.main', compact('destinations', 'popularTours', 'locale'));
    }

    /**
     * AJAX endpoint to change language and return updated content
     */
    public function changeLanguage(Request $request): JsonResponse
    {
        $locale = $request->get('locale', 'en');

        if (!in_array($locale, ['en', 'de', 'fr'])) {
            return response()->json(['error' => 'Invalid locale'], 400);
        }

        // Set the locale
        app()->setLocale($locale);

        // Get updated data
        $destinations = $this->interfaceService->getDestinationsWithLatestTours();
        $popularTours = $this->interfaceService->getPopularTours();

        // Prepare data for JSON response
        $destinationsData = $destinations->map(function ($destination) {
            return [
                'id' => $destination->id,
                'name' => $destination->getTranslatedName(),
                'description' => $destination->getTranslatedDescription(),
                'image' => $destination->image,
                'slug' => $destination->slug,
                'tours' => $destination->tours->map(function ($tour) {
                    return [
                        'id' => $tour->id,
                        'title' => $tour->getTranslatedTitle(),
                        'description' => $tour->getTranslatedDescription(),
                        'image' => is_array($tour->image) ? $tour->image[0] : $tour->image,
                        'price' => $tour->ratePlans->first()->price ?? 0
                    ];
                })
            ];
        });

        $popularToursData = $popularTours->map(function ($tour) {
            return [
                'id' => $tour->id,
                'title' => $tour->getTranslatedTitle(),
                'description' => $tour->getTranslatedDescription(),
                'image' => is_array($tour->image) ? $tour->image[0] : $tour->image,
                'price' => $tour->ratePlans->first()->price ?? 0
            ];
        });

        return response()->json([
            'locale' => $locale,
            'destinations' => $destinationsData,
            'popularTours' => $popularToursData,
            'latestTours' => $popularToursData // Using same data for now
        ]);
    }

    /**
     * Display tours page for specific destination
     */
    public function tours(Request $request, string $destination = null): View
    {
        // Set locale if provided
        $locale = $request->get('locale', 'en');
        if (in_array($locale, ['en', 'de', 'fr'])) {
            app()->setLocale($locale);
        }

        $filters = $request->only(['search', 'duration', 'type', 'price_min', 'price_max', 'rating']);
        $tours = $this->interfaceService->getFilteredTours($destination, $filters);
        $destinations = $this->interfaceService->getAllDestinations();

        return view('interface.tours', compact('tours', 'destinations', 'destination', 'filters', 'locale'));
    }
    public function toursByType(Request $request, string $destination, string $type): View
    {
        // Set locale
        $locale = $request->get('locale', 'en');
        if (in_array($locale, ['en', 'de', 'fr'])) {
            app()->setLocale($locale);
        }

        $filters = $request->only(['search', 'duration', 'price_min', 'price_max', 'rating']);
        $tours = $this->interfaceService->getFilteredToursByType($destination, $type, $filters);
        $destinations = $this->interfaceService->getAllDestinations();

        return view('interface.tours', compact('tours', 'destinations', 'destination', 'filters', 'locale', 'type'));
    }

    /**
     * Display tour details page
     */
    public function details(Request $request, int $id): View
    {
        // Set locale if provided
        $locale = $request->get('locale', 'en');
        if (in_array($locale, ['en', 'de', 'fr'])) {
            app()->setLocale($locale);
        }

        $tour = $this->interfaceService->getTourWithDetails($id);
        $relatedTours = $this->interfaceService->getRelatedTours($tour->destination_id, $id);
        $packages = $this->interfaceService->getTourPackages($id);

        if (!$tour) {
            abort(404);
        }

        return view('interface.details', compact('tour', 'relatedTours', 'packages', 'locale'));
    }

    /**
     * Handle booking requests
     */
    public function book(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'tour_id' => 'required|exists:tours,id',
                'rate_plan_id' => 'required|exists:rate_plans,id',
                'customer_name' => 'required|string|max:100',
                'customer_phone' => 'required|string|max:20',
                'customer_email' => 'nullable|email|max:150',
                'check_in_date' => 'required|date|after_or_equal:tomorrow',
                'check_out_date' => 'required|date|after:check_in_date',
                // 'adults' => 'nullable|integer|min:2|max:2', // Removed adults field
                'children' => 'nullable|integer|min:0|max:20',
                'room_type' => 'required|string|in:standard', // Only standard room
                'special_requests' => 'nullable|string|max:1000',
                'payment_method' => 'required|string|in:bank_transfer,instapay',
                'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $booking = $this->interfaceService->createBooking($validated, $request);

            return response()->json([
                'success' => true,
                'booking_reference' => $booking->booking_reference,
                'message' => 'Booking created successfully! We will contact you within 24 hours to confirm your booking.',
                'booking_summary' => $booking->getBookingSummary()
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Booking creation failed: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'user_ip' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating your booking. Please try again.'
            ], 500);
        }
    }

    /**
     * Get pricing calculation for AJAX
     */
    public function pricing(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:tour_packages,id',
            'adults' => 'nullable|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'nights' => 'required|integer|min:1',
            'room_type' => 'required|string'
        ]);

        $pricing = $this->interfaceService->calculatePricing($validated);

        return response()->json($pricing);
    }

    /**
     * Search tours via AJAX
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $destination = $request->get('destination');

        $results = $this->interfaceService->searchTours($query, $destination);

        return response()->json($results);
    }
}
