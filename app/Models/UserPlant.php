<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Services\WateringScheduleService;

class UserPlant extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'plant_id',
        'nickname',
        'location',
        'notes',
        'acquired_date',
        'death_date',
        'mycorrhiza',
        'mycorrhiza_date',
    ];
    protected $appends = ['average_watering_interval', 'next_watering_date'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
    public function wateringLogs(): HasMany
    {
        return $this->hasMany(WateringLog::class);
    }
    protected function averageWateringInterval(): Attribute
    {
        return Attribute::make(
            get: function () {
                $wateringLogs = $this->wateringLogs()
                    ->orderBy('watering_date', 'desc')
                    ->get();
                    
                return (new WateringScheduleService($wateringLogs))
                    ->calculateAverageInterval();
            }
        );
    }
    protected function nextWateringDate(): Attribute
    {
        return Attribute::make(
            get: function () {
                $wateringLogs = $this->wateringLogs()
                    ->orderBy('watering_date', 'desc')
                    ->get();
                    
                return (new WateringScheduleService($wateringLogs))
                    ->getNextWateringDate();
            }
        );
    }
}
