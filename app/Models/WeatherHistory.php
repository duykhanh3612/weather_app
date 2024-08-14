<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherHistory extends Model
{
    use HasFactory;

    protected $fillable = ['city', 'weather_data'];

    // Cast weather_data to an array
    protected $casts = [
        'weather_data' => 'array',
    ];
}
