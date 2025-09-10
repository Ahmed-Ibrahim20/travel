<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class RatePlan extends Model
{
    use HasFactory;

    protected $table = 'rate_plans';

    /**
     * الأعمدة المسموح بالـ Mass Assignment
     */
    protected $fillable = [
        'tour_id',
        'name',
        'room_type',
        'start_date',
        'end_date',
        'board_type',
        'transportation',
        'price',
        'currency',
        'details',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'name' => 'array',
        'details' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * علاقة مع Tour
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * ترجمة الاسم حسب اللغة الحالية
     */
    public function getTranslatedName(?string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        return $this->name[$locale] ?? $this->name['en'] ?? '';
    }

    /**
     * ترجمة التفاصيل حسب اللغة الحالية
     */
    public function getTranslatedDetails(?string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        return $this->details[$locale] ?? $this->details['en'] ?? '';
    }

    /**
     * Accessor لعرض السعر مع العملة
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2) . ' ' . strtoupper($this->currency);
    }
}
