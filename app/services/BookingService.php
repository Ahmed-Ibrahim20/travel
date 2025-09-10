<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\RatePlan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class BookingService
{
    /**
     * Create a new booking
     */
    public function createBooking(array $data): Booking
    {
        // Calculate number of nights
        $checkIn = Carbon::parse($data['check_in_date']);
        $checkOut = Carbon::parse($data['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);

        // Get tour and rate plan data
        $tour = Tour::findOrFail($data['tour_id']);
        $ratePlan = RatePlan::findOrFail($data['rate_plan_id']);

        // Calculate total price
        $pricing = $this->calculatePricing([
            'rate_plan' => $ratePlan,
            'adults' => $data['adults'],
            'children' => $data['children'] ?? 0,
            'nights' => $nights,
            'room_type' => $data['room_type']
        ]);

        // Create the booking
        $booking = Booking::create([
            'tour_id' => $data['tour_id'],
            'rate_plan_id' => $data['rate_plan_id'],
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_email' => $data['customer_email'] ?? null,
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
            'adults' => $data['adults'],
            'children' => $data['children'] ?? 0,
            'nights' => $nights,
            'room_type' => $data['room_type'],
            'special_requests' => $data['special_requests'] ?? null,
            'base_price' => $ratePlan->price,
            'total_amount' => $pricing['total'],
            'currency' => $ratePlan->currency ?? 'EGP',
            'payment_method' => $data['payment_method'],
            'payment_reference' => $data['payment_reference'] ?? null,
            'receipt_image' => $data['receipt_image'] ?? null,
            'booking_status' => 'pending',
            'payment_status' => 'pending'
        ]);

        return $booking;
    }

    /**
     * Calculate booking pricing
     */
    public function calculatePricing(array $data): array
    {
        $ratePlan = $data['rate_plan'];
        $adults = $data['adults'];
        $children = $data['children'] ?? 0;
        $nights = $data['nights'];
        $roomType = $data['room_type'];

        // Base price per person
        $basePrice = $ratePlan->price;

        // Room upgrade costs
        $upgradeCosts = [
            'standard' => 0,
            'pool_sea' => 400,
            'sea_facing' => 500,
            'superior' => 700
        ];

        $upgradePerNight = $upgradeCosts[$roomType] ?? 0;

        // Child policy: first child free, remaining children pay 50%
        $childCharge = 0;
        if ($children > 0) {
            $childCharge = max(0, $children - 1) * ($basePrice * 0.5);
        }

        // Calculate costs
        $peopleCost = ($adults * $basePrice + $childCharge) * $nights;
        $upgradeCost = $upgradePerNight * $nights;
        $subtotal = $peopleCost + $upgradeCost;

        // Taxes (14% VAT)
        $taxRate = 0.14;
        $taxes = $subtotal * $taxRate;
        $total = $subtotal + $taxes;

        return [
            'base_price' => $basePrice,
            'nights' => $nights,
            'adults' => $adults,
            'children' => $children,
            'people_cost' => $peopleCost,
            'upgrade_cost' => $upgradeCost,
            'subtotal' => $subtotal,
            'taxes' => $taxes,
            'total' => round($total, 2),
            'currency' => $ratePlan->currency ?? 'EGP'
        ];
    }

    /**
     * Get all bookings with filtering and pagination
     */
    public function getAllBookings(array $filters = []): LengthAwarePaginator
    {
        $query = Booking::with(['tour', 'ratePlan']);

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('booking_status', $filters['status']);
        }

        // Filter by payment method
        if (!empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        // Filter by phone number
        if (!empty($filters['phone'])) {
            $query->byPhone($filters['phone']);
        }

        // Filter by booking reference
        if (!empty($filters['booking_reference'])) {
            $query->where('booking_reference', 'like', '%' . $filters['booking_reference'] . '%');
        }

        // Filter by date range
        if (!empty($filters['date_from'])) {
            $query->where('check_in_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('check_in_date', '<=', $filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    /**
     * Get single booking with details
     */
    public function getBookingById(int $id): ?Booking
    {
        return Booking::with(['tour', 'ratePlan'])->find($id);
    }

    /**
     * Update booking status
     */
    public function updateBookingStatus(int $id, string $status, ?string $adminNotes = null): bool
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return false;
        }

        $booking->update([
            'booking_status' => $status,
            'admin_notes' => $adminNotes
        ]);

        return true;
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(int $id, string $paymentStatus, ?string $paymentReference = null): bool
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return false;
        }

        $updateData = ['payment_status' => $paymentStatus];

        if ($paymentReference) {
            $updateData['payment_reference'] = $paymentReference;
        }

        $booking->update($updateData);

        return true;
    }

    /**
     * Delete booking
     */
    public function deleteBooking(int $id): bool
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return false;
        }

        return $booking->delete();
    }

    /**
     * Get pending bookings
     */
    public function getPendingBookings(): Collection
    {
        return Booking::with(['tour', 'ratePlan'])
            ->pending()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get booking statistics
     */
    public function getBookingStats(): array
    {
        $total = Booking::count();
        $pending = Booking::where('booking_status', 'pending')->count();
        $confirmed = Booking::where('booking_status', 'confirmed')->count();
        $cancelled = Booking::where('booking_status', 'cancelled')->count();
        $completed = Booking::where('booking_status', 'completed')->count();

        $totalRevenue = Booking::where('booking_status', 'confirmed')
            ->orWhere('booking_status', 'completed')
            ->sum('total_amount');

        return [
            'total' => $total,
            'pending' => $pending,
            'confirmed' => $confirmed,
            'cancelled' => $cancelled,
            'completed' => $completed,
            'total_revenue' => $totalRevenue
        ];
    }

    /**
     * Search bookings
     */
    public function searchBookings(string $query): Collection
    {
        return Booking::with(['tour', 'ratePlan'])
            ->where(function ($q) use ($query) {
                $q->where('customer_name', 'like', '%' . $query . '%')
                  ->orWhere('customer_phone', 'like', '%' . $query . '%')
                  ->orWhere('booking_reference', 'like', '%' . $query . '%')
                  ->orWhere('customer_email', 'like', '%' . $query . '%');
            })
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
    }
}
