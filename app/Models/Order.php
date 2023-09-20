<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_name',
        'address',
        'city',
        'country',
        'postcode',
        'mobile',
        'email',
        'order_notes',
        'status',
        'subtotal',
    ];
}
