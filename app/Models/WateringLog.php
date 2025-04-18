<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WateringLog extends BaseModel
{
    /** @use HasFactory<\Database\Factories\WateringLogFactory> */
    use HasFactory;
    protected $fillable = [
        'user_plant_id',
        'watering_date',
        'watering_method',
        'with_fertilizer',
        'with_trichoderma',
        'with_slow_release'
    ];
}

