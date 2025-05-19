<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'consumer_id',
        'total_price',
        'status',
        'payment_method',
        'delivery_address',
        'delivery_instructions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'total_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the consumer that owns the order.
     */
    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }

    public function getTotalItemsAttribute()
    {
        return $this->items()->sum('quantity_kg');
    }
     public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Get the formatted status attribute.
     */
    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Get the status badge HTML.
     */
    public function getStatusBadgeAttribute()
    {
       $badgeClass = match($this->status) {
        'delivered' => 'bg-label-success',
        'pending' => 'bg-label-warning',
        'confirmed' => 'bg-label-primary',
        'cancelled' => 'bg-label-danger',
        'shipped' => 'bg-label-info',
        default => 'bg-label-secondary',
    };


        return '<span class="badge ' . $badgeClass . '">' . $this->formatted_status . '</span>';
    }
}