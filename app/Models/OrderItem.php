<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'consumer_id',
        'fish_product_id',
        'image_path',
        'quantity_kg',
        'price_per_kg',
        'subtotal'
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the consumer that owns the order item.
     */
    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }

    /**
     * Get the fish product associated with this order item.
     */
    public function fishProduct()
    {
        return $this->belongsTo(FishProduct::class, 'fish_product_id');
    }
}