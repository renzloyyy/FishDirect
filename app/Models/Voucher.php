<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount',
        'type',
        'minimum_order_amount',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'discount' => 'float',
        'minimum_order_amount' => 'float',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];
}
