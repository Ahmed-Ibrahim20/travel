<?php

namespace App\Services;

use App\Models\Destination;
use App\Models\Tour;
use App\Models\RatePlan;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class InterfaceService
{
    /**
     * Get destinations with their latest tours for main page
     */
    public function getDestinationsWithLatestTours(): Collection
    {
        return Destination::with(['tours' => function ($query) {
            $query->with('ratePlans')->orderBy('created_at', 'desc')->limit(6);
        }])->get();
    }

    /**
     * Get all active destinations
     */
    public function getAllDestinations(): Collection
    {
        return Destination::withCount('tours')->get();
    }

    /**
     * Get popular tours for Swiper section
     */
    public function getPopularTours(int $limit = 8): Collection
    {
        return Tour::with(['destination', 'ratePlans'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get featured testimonials
     */
    // public function getFeaturedTestimonials(int $limit = 6): Collection
    // {
    //     return Testimonial::where('is_approved', true)
    //         ->where('is_featured', true)
    //         ->orderBy('created_at', 'desc')
    //         ->limit($limit)
    //         ->get();
    // }

    /**
     * Get filtered tours with pagination
     */
    public function getFilteredTours(?string $destination = null, array $filters = []): LengthAwarePaginator
    {
        $query = Tour::with(['destination', 'ratePlans']);

        // Filter by destination
        if ($destination) {
            $query->whereHas('destination', function ($q) use ($destination) {
                $q->where('slug', $destination);
            });
        }

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Apply duration filter
        if (!empty($filters['duration'])) {
            $query->where('duration_days', $filters['duration']);
        }

        // Apply price filters
        if (!empty($filters['price_min']) || !empty($filters['price_max'])) {
            $query->whereHas('ratePlans', function ($q) use ($filters) {
                if (!empty($filters['price_min'])) {
                    $q->where('price', '>=', $filters['price_min']);
                }
                if (!empty($filters['price_max'])) {
                    $q->where('price', '<=', $filters['price_max']);
                }
            });
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate(12);
    }
    //  Get filtered tours by type with pagination

    public function getFilteredToursByType(string $destination, string $type, array $filters = []): LengthAwarePaginator
    {
        $query = Tour::with(['destination', 'ratePlans'])
            ->where('tour_type', $type); // ✅ فلترة حسب النوع

        // فلترة بالـ destination
        if ($destination) {
            $query->whereHas('destination', function ($q) use ($destination) {
                $q->where('slug', $destination);
            });
        }

        // باقي الفلاتر زي البحث/المدة/السعر/التقييم
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['duration'])) {
            $query->where('duration_days', $filters['duration']);
        }

        if (!empty($filters['price_min']) || !empty($filters['price_max'])) {
            $query->whereHas('ratePlans', function ($q) use ($filters) {
                if (!empty($filters['price_min'])) {
                    $q->where('price', '>=', $filters['price_min']);
                }
                if (!empty($filters['price_max'])) {
                    $q->where('price', '<=', $filters['price_max']);
                }
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(12);
    }

    /**
     * Get tour with full details
     */
    public function getTourWithDetails(int $id): ?Tour
    {
        return Tour::with([
            'destination',
            'ratePlans'
        ])->find($id);
    }

    /**
     * Get related tours from same destination
     */
    public function getRelatedTours(int $destinationId, int $excludeId, int $limit = 4): Collection
    {
        return Tour::with(['destination', 'ratePlans'])
            ->where('destination_id', $destinationId)
            ->where('id', '!=', $excludeId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get tour rate plans
     */
    public function getTourPackages(int $tourId): Collection
    {
        return RatePlan::where('tour_id', $tourId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Calculate professional booking pricing
     */
    public function calculateBookingPricing(array $data): array
    {
        $ratePlan = $data['rate_plan'];
        $adults = $data['adults']?? 0;
        $children = $data['children'] ?? 0;
        $nights = $data['nights'];
        $roomType = $data['room_type'];

        // Get base price per person from rate plan
        $basePrice = $ratePlan->price;

        // Room upgrade costs per night
        $upgradeCosts = [
            'standard' => 0,
            'pool_sea' => 400,
            'sea_facing' => 500,
            'superior' => 700
        ];

        $upgradePerNight = $upgradeCosts[$roomType] ?? 0;
        $totalUpgradeCost = $upgradePerNight * $nights;

        // Child policy: children under 12 are 50% of adult price
        $childPrice = $basePrice * 0.5;
        
        // New children pricing: ≤2 free, >2 = +$10 per extra child per night
        $childrenCost = 0;
        if ($children > 2) {
            $extraChildren = $children - 2;
            $childrenCost = $extraChildren * 10 * $nights; // $10 per extra child per night
        }
        
        // Base cost for 2 adults (included in package price)
        $baseCost = $basePrice * $nights;
        $peopleCost = $baseCost + $childrenCost;
        
        // Calculate subtotal
        $subtotal = $peopleCost + $totalUpgradeCost;

        // No tax - final price is the subtotal
        $taxAmount = 0;
        $totalAmount = $subtotal;

        return [
            'base_price' => $basePrice,
            'nights' => $nights,
            'adults' => $adults,
            'children' => $children,
            'children_cost' => $childrenCost,
            'people_cost' => $peopleCost,
            'room_upgrade_cost' => $totalUpgradeCost,
            'subtotal' => round($subtotal, 2),
            'tax_rate' => 0,
            'tax_amount' => round($taxAmount, 2),
            'total_amount' => round($totalAmount, 2),
            'currency' => 'USD'
        ];
    }

    /**
     * Calculate pricing for AJAX requests (legacy support)
     */
    public function calculatePricing(array $data): array
    {
        // This method is kept for backward compatibility
        $ratePlan = RatePlan::find($data['rate_plan_id'] ?? $data['package_id']);
        
        if (!$ratePlan) {
            throw new \Exception('Rate plan not found');
        }
        
        return $this->calculateBookingPricing([
            'rate_plan' => $ratePlan,
            'adults' => $data['adults']?? 0,
            'children' => $data['children'] ?? 0,
            'nights' => $data['nights'],
            'room_type' => $data['room_type']
        ]);
    }

    /**
     * Create a new booking with professional pricing calculation
     */
    public function createBooking(array $validated, Request $request): Booking
    {
        // Get rate plan for pricing
        $ratePlan = RatePlan::findOrFail($validated['rate_plan_id']);
        
        // Calculate nights
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        
        // Calculate pricing
        $pricing = $this->calculateBookingPricing([
            'rate_plan' => $ratePlan,
            'adults' => 2, // Always 2 adults (hardcoded)
            'children' => $validated['children'] ?? 0,
            'nights' => $nights,
            'room_type' => $validated['room_type']
        ]);
        
        // Handle receipt image upload
        $receiptPath = null;
        if ($request->hasFile('receipt_image')) {
            $receiptPath = $this->storeReceiptImage($request->file('receipt_image'));
        }
        
        // Create booking
        $booking = Booking::create([
            'tour_id' => $validated['tour_id'],
            'rate_plan_id' => $validated['rate_plan_id'],
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'] ?? null,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'adults' => 2, // Always 2 adults (hardcoded)
            'children' => $validated['children'] ?? 0,
            'nights' => $nights,
            'room_type' => $validated['room_type'],
            'special_requests' => $validated['special_requests'] ?? null,
            'base_price' => $pricing['base_price'],
            'room_upgrade_cost' => $pricing['room_upgrade_cost'],
            'subtotal' => $pricing['subtotal'],
            'tax_amount' => $pricing['tax_amount'],
            'total_amount' => $pricing['total_amount'],
            'currency' => 'USD',
            'payment_method' => $validated['payment_method'],
            'receipt_image' => $receiptPath,
            'payment_status' => $receiptPath ? 'paid' : 'pending',
            'booking_status' => 'pending'
        ]);
        
        return $booking;
    }

    /**
     * Search tours
     */
    public function searchTours(string $query, ?string $destination = null): array
    {
        $tours = Tour::with(['destination', 'ratePlans'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            });

        if ($destination) {
            $tours->whereHas('destination', function ($q) use ($destination) {
                $q->where('slug', $destination);
            });
        }

        return $tours->limit(10)->get()->map(function ($tour) {
            $firstRatePlan = $tour->ratePlans->first();
            return [
                'id' => $tour->id,
                'title' => $tour->getTranslatedTitle(),
                'destination' => $tour->destination->getTranslatedName(),
                'price' => $firstRatePlan ? $firstRatePlan->price : 0,
                'image' => $tour->image,
                'url' => route('interface.details', $tour->id)
            ];
        })->toArray();
    }

    /**
     * Generate unique booking reference
     */
    // private function generateBookingReference(): string
    // {
    //     do {
    //         $reference = 'BT' . date('Y') . strtoupper(substr(uniqid(), -6));
    //     } while (Booking::where('booking_reference', $reference)->exists());

    //     return $reference;
    // }

    /**
     * Store receipt image in public folder
     */
    protected function storeReceiptImage(\Illuminate\Http\UploadedFile $image): string
    {
        $folder = 'assets/images/receipts';
        $publicPath = public_path($folder);

        // Ensure folder exists
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }

        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $fileName = $originalName . '_' . now()->format('Ymd_His') . '.' . $extension;
        $image->move($publicPath, $fileName);
        return url($folder . '/' . $fileName);
    }
}
