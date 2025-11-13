<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * Note: do not use the 'hashed' cast here because the registration
     * controller already hashes passwords explicitly using Hash::make.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Helper methods untuk check role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVendor()
    {
        return $this->role === 'vendor';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function store()
    {
        return $this->hasOne(\App\Models\Store::class, 'user_id');
    }

    public function shopRequest()
    {
        return $this->hasOne(\App\Models\ShopRequest::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'user_id');
    }

    /**
     * Email normalization mutator
     * @param string $value
     * @phpstan-ignore-next-line
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = Str::lower(trim($value));
    }
}
