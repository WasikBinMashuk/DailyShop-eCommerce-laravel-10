<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = [
        'slider_title',
        'slider_image',
        'slider_link',
        'status',
    ];

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
