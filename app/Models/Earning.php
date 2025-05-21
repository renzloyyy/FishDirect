<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    protected $fillable = [
        'fisher_id',
        'order_item_id',
        'amount',
        'status',
        'notes',
    ];

    public function fisher()
    {
        return $this->belongsTo(Fisher::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    
    public function order()
    {
        return $this->hasOneThrough(
            Order::class,   
            OrderItem::class,
            'id',             
            'id',            
            'order_item_id',  
            'order_id'        
        );
    }
}
