<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of bookings with search and filtering
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['booking_status', 'payment_method', 'phone', 'booking_reference', 'date_from', 'date_to']);
        $bookings = $this->bookingService->getAllBookings($filters);
        $stats = $this->bookingService->getBookingStats();

        return view('bookings.index', compact('bookings', 'stats', 'filters'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create(): View
    {
        $tours = \App\Models\Tour::with('destination')->get();
        return view('bookings.create', compact('tours'));
    }

    /**
     * Store a newly created booking
     */
    public function store(BookingRequest $request): JsonResponse
    {
        try {
            $booking = $this->bookingService->createBooking($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully! We will contact you soon to confirm your booking.',
                'booking' => [
                    'id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'total_amount' => $booking->formatted_total,
                    'payment_method' => $booking->payment_method_label
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating booking. Please try again.'
            ], 500);
        }
    }

    /**
     * Display the specified booking
     */
    public function show(int $id)
    {
        $booking = $this->bookingService->getBookingById($id);

        if (!$booking) {
            return redirect()->route('bookings.index')->with('error', 'الحجز غير موجود.');
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking
     */
    public function edit(int $id)
    {
        $booking = $this->bookingService->getBookingById($id);

        if (!$booking) {
            return redirect()->route('bookings.index')->with('error', 'الحجز غير موجود.');
        }

        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified booking status (AJAX)
     */
    public function updateBookingStatus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,cancelled,completed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        try {
            $result = $this->bookingService->updateBookingStatus(
                $id, 
                $request->status, 
                $request->admin_notes
            );

            return response()->json([
                'success' => $result,
                'message' => $result ? 'Booking status updated successfully.' : 'Error updating booking status.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating booking status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update payment status (AJAX)
     */
    public function updatePaymentStatus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|string|in:pending,paid,verified,failed,refunded',
            'payment_reference' => 'nullable|string|max:255'
        ]);

        try {
            $result = $this->bookingService->updatePaymentStatus(
                $id, 
                $request->status, 
                $request->payment_reference
            );

            return response()->json([
                'success' => $result,
                'message' => $result ? 'Payment status updated successfully.' : 'Error updating payment status.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating payment status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified booking
     */
    public function destroy(int $id): RedirectResponse
    {
        $result = $this->bookingService->deleteBooking($id);

        return $result
            ? redirect()->route('bookings.index')->with('success', 'تم حذف الحجز بنجاح.')
            : redirect()->back()->with('error', 'حدث خطأ أثناء حذف الحجز.');
    }

    /**
     * Get rate plans for a specific tour (AJAX)
     */
    public function getTourRatePlans(int $tourId): JsonResponse
    {
        $tour = \App\Models\Tour::with('ratePlans')->find($tourId);

        if (!$tour) {
            return response()->json(['error' => 'الرحلة غير موجودة'], 404);
        }

        $ratePlans = $tour->ratePlans->map(function ($ratePlan) {
            return [
                'id' => $ratePlan->id,
                'name' => $ratePlan->getTranslatedName(),
                'price' => $ratePlan->price,
                'formatted_price' => $ratePlan->formatted_price,
                'currency' => $ratePlan->currency,
                'room_type' => $ratePlan->room_type,
                'board_type' => $ratePlan->board_type,
                'start_date' => $ratePlan->start_date?->format('Y-m-d'),
                'end_date' => $ratePlan->end_date?->format('Y-m-d'),
            ];
        });

        return response()->json([
            'tour' => [
                'id' => $tour->id,
                'title' => $tour->getTranslatedTitle(),
                'destination' => $tour->destination->getTranslatedName()
            ],
            'rate_plans' => $ratePlans
        ]);
    }

    /**
     * Calculate pricing for booking (AJAX)
     */
    public function calculatePricing(Request $request): JsonResponse
    {
        $request->validate([
            'rate_plan_id' => 'required|exists:rate_plans,id',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'room_type' => 'required|string'
        ]);

        try {
            $ratePlan = \App\Models\RatePlan::findOrFail($request->rate_plan_id);
            $checkIn = \Carbon\Carbon::parse($request->check_in_date);
            $checkOut = \Carbon\Carbon::parse($request->check_out_date);
            $nights = $checkIn->diffInDays($checkOut);

            $pricing = $this->bookingService->calculatePricing([
                'rate_plan' => $ratePlan,
                'adults' => $request->adults,
                'children' => $request->children ?? 0,
                'nights' => $nights,
                'room_type' => $request->room_type
            ]);

            return response()->json([
                'success' => true,
                'pricing' => $pricing
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حساب السعر'
            ], 500);
        }
    }

    /**
     * Search bookings (AJAX)
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $bookings = $this->bookingService->searchBookings($query);

        return response()->json([
            'bookings' => $bookings->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'customer_name' => $booking->customer_name,
                    'customer_phone' => $booking->customer_phone,
                    'tour_title' => $booking->tour->getTranslatedTitle(),
                    'total_amount' => $booking->formatted_total,
                    'status' => $booking->status_label,
                    'created_at' => $booking->created_at->format('Y-m-d H:i')
                ];
            })
        ]);
    }

    /**
     * Upload payment receipt
     */
    public function uploadReceipt(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'receipt' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $booking = $this->bookingService->getBookingById($id);
            
            if (!$booking) {
                return response()->json(['success' => false, 'message' => 'الحجز غير موجود'], 404);
            }

            if ($request->hasFile('receipt')) {
                $file = $request->file('receipt');
                $filename = 'receipt_' . $booking->booking_reference . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('receipts', $filename, 'public');

                // Update booking with receipt path
                $booking->update(['payment_reference' => $path]);

                return response()->json([
                    'success' => true,
                    'message' => 'تم رفع إيصال الدفع بنجاح',
                    'receipt_path' => $path
                ]);
            }

            return response()->json(['success' => false, 'message' => 'لم يتم اختيار ملف'], 400);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء رفع الإيصال'], 500);
        }
    }
}
