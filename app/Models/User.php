<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'role',
        'sso_provider',  // Added for SSO
        'sso_id',        // Added for SSO
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'sso_id',       
    ];

    public function consumer()
    {
        return $this->hasOne(Consumer::class);
    }

    public function fisher()
    {
        return $this->hasOne(Fisher::class);  
    }
}
