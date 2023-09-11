<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'password' => 'hashed',
    ];
}
