<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fisher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'fishing_license',
        'fisher_type',
        'boat_name',
        'fishing_area',
        'fishing_experience_years',
        'display_name',
        'bio',
        'profile_photo',
        'fish_types',
        'quantity_per_catch',
        'sustainable_method',
        'payout_method',
        'bank_name',
        'account_holder',
        'account_number',
        'agreed_terms',
    ];
    
    public const FISHER_TYPES = [
        'Small-scale',
        'Deep sea',
        'Inland',
        'Aquaculture',
    ];
    
    protected $casts = [
        'fish_types' => 'array',
        'agreed_terms' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
