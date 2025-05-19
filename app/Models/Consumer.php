<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consumer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'street',
        'barangay',
        'city',
        'province',
        'zip_code',
        'delivery_instructions',
        'preferred_fish_types',
        'dietary_restrictions',
        'preferred_payment_method',
        'agreed_terms', // ✅ Make sure it's fillable
    ];

    protected $casts = [
        'preferred_fish_types' => 'array',
        // 'agreed_terms' => 'boolean', ❌ Remove this cast now that it's VARCHAR
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
