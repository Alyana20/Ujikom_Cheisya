<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_description',
        'shop_address',
        'shop_phone',
        'status',
        'rejection_reason',
        'submitted_at',
        'approved_at',
        'rejected_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
