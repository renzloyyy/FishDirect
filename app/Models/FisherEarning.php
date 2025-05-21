<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FisherEarning extends Model
{
    use HasFactory;

    protected $table = 'fisher_earnings';

    protected $fillable = [
        'fisher_id',
        'order_id',
        'product_name',
        'quantity_kg',
        'price_per_kg',
        'total_earning',
        'platform_fee',
        'net_earning',
        'payout_status',
        'payout_date',
        'payout_reference'
    ];

    protected $casts = [
        'payout_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    
    public function fisher()
    {
        return $this->belongsTo(Fisher::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}