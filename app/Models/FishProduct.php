<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FishProduct extends Model
{
    use HasFactory;

    protected $table = 'fish_products';

    protected $fillable = [
        'fisher_id',
        'name',
        'description',
        'image_path',
        'price_per_kg',
        'status',
        'catch_date',
        'stock_kg',
    ];

    public function fisher()
    {
        return $this->belongsTo(Fisher::class);
    }
}
