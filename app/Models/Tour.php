<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Tour extends Model
{
    use HasFactory;

    protected $table = 'tours';

    /**
     * الأعمدة اللي ممكن تعمل Mass Assignment
     */
    protected $fillable = [
        'destination_id',
        'title',
        'description',
        'capacity',
        'image',
        'rating',
        'tour_type',
        'hotel_info',
        'package_info',
        'user_add_id',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'image' => 'array', // هنا عشان ممكن تكون أكتر من صورة
        'hotel_info' => 'array',
        'package_info' => 'array',
        'rating' => 'decimal:1',
    ];

    /**
     * علاقة مع Destination
     */
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * العلاقة مع User اللي أضاف التور
     */
    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'user_add_id');
    }

    /**
     * العلاقة مع Rate Plans
     */
    public function ratePlans()
    {
        return $this->hasMany(RatePlan::class);
    }

    /**
     * ترجمة العنوان حسب اللغة الحالية
     */
    public function getTranslatedTitle(?string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        return $this->title[$locale] ?? $this->title['en'] ?? '';
    }

    /**
     * ترجمة الوصف حسب اللغة الحالية
     */
    public function getTranslatedDescription(?string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        return $this->description[$locale] ?? $this->description['en'] ?? '';
    }

    /**
     * Accessor للصور (يرجع Array of URLs)
     */
    public function getImageUrlsAttribute(): array
    {
        $urls = [];

        if (is_array($this->image)) {
            foreach ($this->image as $img) {
                if (Storage::disk('public')->exists($img)) {
                    $urls[] = Storage::url($img);
                } else {
                    $urls[] = $img; // ممكن يكون لينك خارجي
                }
            }
        }

        return $urls;
    }
}
