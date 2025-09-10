<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tour_id',
        'rate_plan_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'check_in_date',
        'check_out_date',
        'adults',
        'children',
        'nights',
        'room_type',
        'special_requests',
        'base_price',
        'room_upgrade_cost',
        'subtotal',
        'tax_amount',
        'total_amount',
        'currency',
        'payment_method',
        'payment_reference',
        'receipt_image',
        'payment_status',
        'payment_date',
        'booking_status',
        'booking_reference',
        'admin_notes',
        'confirmed_at',
        'cancelled_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'base_price' => 'decimal:2',
        'room_upgrade_cost' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Boot method to automatically generate booking reference
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = static::generateBookingReference();
            }
        });
    }

    /**
     * Relationship with Tour
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Relationship with RatePlan
     */
    public function ratePlan()
    {
        return $this->belongsTo(RatePlan::class);
    }

    /**
     * Generate unique booking reference
     */
    public static function generateBookingReference(): string
    {
        do {
            $reference = 'TRV' . date('y') . strtoupper(Str::random(8));
        } while (static::where('booking_reference', $reference)->exists());

        return $reference;
    }

    /**
     * Accessor for formatted total amount
     */
    public function getFormattedTotalAttribute(): string
    {
        return number_format((float)$this->total_amount, 2) . ' ' . strtoupper($this->currency);
    }

    /**
     * Accessor for booking status label in English
     */
    public function getBookingStatusLabelAttribute(): string
    {
        return match($this->booking_status) {
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            default => ucfirst($this->booking_status)
        };
    }

    /**
     * Accessor for payment method label in English
     */
    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'bank_transfer' => 'Bank Transfer',
            'instapay' => 'InstaPay',
            default => ucfirst(str_replace('_', ' ', $this->payment_method))
        };
    }

    /**
     * Accessor for payment status label in English
     */
    public function getPaymentStatusLabelAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'Pending Payment',
            'paid' => 'Payment Received',
            'verified' => 'Payment Verified',
            'failed' => 'Payment Failed',
            'refunded' => 'Payment Refunded',
            default => ucfirst($this->payment_status)
        };
    }

    /**
     * Scope for pending bookings
     */
    public function scopePending($query)
    {
        return $query->where('booking_status', 'pending');
    }

    /**
     * Scope for confirmed bookings
     */
    public function scopeConfirmed($query)
    {
        return $query->where('booking_status', 'confirmed');
    }

    /**
     * Scope for completed bookings
     */
    public function scopeCompleted($query)
    {
        return $query->where('booking_status', 'completed');
    }

    /**
     * Scope for cancelled bookings
     */
    public function scopeCancelled($query)
    {
        return $query->where('booking_status', 'cancelled');
    }

    /**
     * Scope for search by phone
     */
    public function scopeByPhone($query, $phone)
    {
        return $query->where('customer_phone', 'like', '%' . $phone . '%');
    }

    /**
     * Scope for search by customer name
     */
    public function scopeByCustomerName($query, $name)
    {
        return $query->where('customer_name', 'like', '%' . $name . '%');
    }

    /**
     * Scope for search by booking reference
     */
    public function scopeByBookingReference($query, $reference)
    {
        return $query->where('booking_reference', 'like', '%' . $reference . '%');
    }

    /**
     * Get room type label
     */
    public function getRoomTypeLabelAttribute(): string
    {
        return match($this->room_type) {
            'standard' => 'Standard Room',
            'pool_sea' => 'Pool/Sea View Room',
            'sea_facing' => 'Sea-Facing Room',
            'superior' => 'Superior Room',
            default => ucfirst(str_replace('_', ' ', $this->room_type))
        };
    }

    /**
     * Check if booking can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->booking_status, ['pending', 'confirmed']) && 
               $this->check_in_date->isAfter(now()->addDays(1));
    }

    /**
     * Check if booking can be completed
     */
    public function canBeCompleted(): bool
    {
        return $this->booking_status === 'confirmed' && 
               $this->payment_status === 'paid';
    }

    /**
     * Check if payment can be verified
     */
    public function canVerifyPayment(): bool
    {
        return $this->payment_status === 'paid' && 
               !empty($this->receipt_image);
    }

    /**
     * Get room upgrade cost per night
     */
    public function getRoomUpgradeCostPerNight(): float
    {
        if ($this->nights > 0) {
            return $this->room_upgrade_cost / $this->nights;
        }
        return 0;
    }

    /**
     * Get booking summary for display
     */
    public function getBookingSummary(): array
    {
        return [
            'booking_reference' => $this->booking_reference,
            'customer_name' => $this->customer_name,
            'tour_title' => $this->tour->getTranslatedTitle(),
            'destination' => $this->tour->destination->getTranslatedName(),
            'check_in' => $this->check_in_date?->format('d M Y'),
            'check_out' => $this->check_out_date?->format('d M Y'),
            'nights' => $this->nights,
            'guests' => $this->adults . ' Adults' . ($this->children > 0 ? ', ' . $this->children . ' Children' : ''),
            'room_type' => $this->room_type_label,
            'total_amount' => $this->formatted_total,
            'payment_method' => $this->payment_method_label,
            'payment_status' => $this->payment_status_label,
            'booking_status' => $this->booking_status_label,
        ];
    }

    /**
     * Mark booking as confirmed
     */
    public function markAsConfirmed(): void
    {
        $this->update([
            'booking_status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    /**
     * Mark booking as cancelled
     */
    public function markAsCancelled(string $reason = null): void
    {
        $this->update([
            'booking_status' => 'cancelled',
            'cancelled_at' => now(),
            'admin_notes' => $reason ? 'Cancelled: ' . $reason : 'Cancelled',
        ]);
    }

    /**
     * Mark payment as verified
     */
    public function markPaymentAsVerified(): void
    {
        $this->update([
            'payment_status' => 'verified',
            'payment_date' => now(),
        ]);
    }
}
