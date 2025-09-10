<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Destination extends Model
{
    use HasFactory;

    protected $table = 'destinations';

    /**
     * الأعمدة اللي ممكن تعمل Mass Assignment
     */
    protected $fillable = [
        'name',
        'description',
        'slug',
        'image',
        'user_add_id',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];

    /**
     * العلاقة مع الـ User اللي أضاف الوجهة
     */
    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'user_add_id');
    }

    /**
     * العلاقة مع Tours
     */
    public function tours()
    {
        return $this->hasMany(Tour::class);
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
     * ترجمة الوصف حسب اللغة الحالية
     */
    public function getTranslatedDescription(?string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        return $this->description[$locale] ?? $this->description['en'] ?? '';
    }

    /**
     * لو عاوز تستخدم slug في الروتنج
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Accessor للصورة
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            // لو مرفوعة على storage
            if (Storage::disk('public')->exists($this->image)) {
                return Storage::url($this->image);
            }
            // أو لينك خارجي محفوظ في db
            return $this->image;
        }
        return null;
    }
}
