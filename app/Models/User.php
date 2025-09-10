<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'address',
        'role',
        'image',
        'user_add_id'
    ];

    /**
     * The attributes that should be hidden for arrays (e.g., JSON responses).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'integer',
    ];

    /**
     * Get a human-readable role (optional helper).
     */
    public function getRoleNameAttribute()
    {
        return match ($this->role) {
            0 => 'Customer',
            1 => 'Admin',
            default => 'Unknown',
        };
    }

    /**
     * العلاقة مع Destinations اللي أضافها المستخدم
     */
    public function destinations()
    {
        return $this->hasMany(Destination::class, 'user_add_id');
    }

    /**
     * العلاقة مع Tours اللي أضافها المستخدم
     */
    public function tours()
    {
        return $this->hasMany(Tour::class, 'user_add_id');
    }

    /**
     * العلاقة مع Users اللي أضافهم المستخدم
     */
    public function addedUsers()
    {
        return $this->hasMany(User::class, 'user_add_id');
    }

    /**
     * العلاقة مع User اللي أضاف المستخدم ده
     */
    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'user_add_id');
    }
}
