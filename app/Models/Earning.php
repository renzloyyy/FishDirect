<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    protected $table = 'earnings';

    protected $fillable = [
        'fisher_id',
        'order_item_id',
        'amount',
        'status',
        'payout_method',
        'notes',
    ];

    // Relationships

    public function fisher()
    {
        return $this->belongsTo(Fisher::class, 'fisher_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }
}
