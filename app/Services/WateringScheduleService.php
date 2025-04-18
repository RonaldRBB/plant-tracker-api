<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class WateringScheduleService
{
    private Collection $wateringLogs;
    private ?Carbon $lastWateringDate;
    private ?Carbon $lastFertilizerDate;
    private ?Carbon $lastTrichodermaDate;
    private ?float $averageInterval;
    private int $fertilizerInterval;
    private int $trichodermaInterval;
    private int $minimumWaterings;
    public function __construct(Collection $wateringLogs)
    {
        $this->wateringLogs = $wateringLogs;
        $this->fertilizerInterval = Config::get('watering.intervals.fertilizer', 15);
        $this->trichodermaInterval = Config::get('watering.intervals.trichoderma', 15);
        $this->minimumWaterings = Config::get('watering.minimum_waterings', 2);
        $this->initializeCalculatedValues();
    }
    private function initializeCalculatedValues(): void
    {
        $sortedLogs = $this->wateringLogs->sortByDesc('watering_date');
        $this->lastWateringDate = $this->parseDate($sortedLogs->first()?->watering_date);
        $this->lastFertilizerDate = $this->parseDate(
            $sortedLogs->first(fn($log) => $log->with_fertilizer || $log->with_slow_release)?->watering_date
        );
        $this->lastTrichodermaDate = $this->parseDate(
            $sortedLogs->first(fn($log) => $log->with_trichoderma)?->watering_date
        );
        $this->averageInterval = $this->calculateAverageIntervalValue();
    }
    private function parseDate(?string $date): ?Carbon
    {
        return $date ? Carbon::parse($date) : null;
    }
    private function calculateAverageIntervalValue(): ?float
    {
        $dates = $this->wateringLogs->pluck('watering_date')->sort()->values();
        if ($dates->count() < 2) {
            return null;
        }
        $intervals = collect();
        for ($i = 0; $i < $dates->count() - 1; $i++) {
            $intervals->push(
                Carbon::parse($dates[$i])->diffInDays(Carbon::parse($dates[$i + 1]))
            );
        }
        return $intervals->average() ? round($intervals->average(), 1) : null;
    }
    private function calculateNextWateringDate(): ?array
    {
        if (!$this->lastWateringDate || !$this->averageInterval) {
            return null;
        }
        $nextWateringDate = $this->lastWateringDate->copy()->addDays(ceil($this->averageInterval));
        if ($this->wateringLogs->count() < $this->minimumWaterings) {
            return $this->createWateringResponse($nextWateringDate, false, false);
        }
        return $this->shouldSuggestFirstTreatment($nextWateringDate) ??
            $this->calculateTreatments($nextWateringDate);
    }
    private function shouldSuggestFirstTreatment(Carbon $nextWateringDate): ?array
    {
        if (!$this->lastFertilizerDate && !$this->lastTrichodermaDate) {
            return $this->createWateringResponse($nextWateringDate, false, true);
        }
        return null;
    }
    private function calculateTreatments(Carbon $nextWateringDate): array
    {
        $daysSinceLastFertilizer = $this->getDaysSinceLastTreatment($this->lastFertilizerDate, $nextWateringDate);
        $daysSinceLastTrichoderma = $this->getDaysSinceLastTreatment($this->lastTrichodermaDate, $nextWateringDate);
        if ($this->shouldSuggestFertilizer($daysSinceLastFertilizer, $daysSinceLastTrichoderma)) {
            return $this->createWateringResponse($nextWateringDate, true, false);
        }
        if ($this->shouldSuggestTrichoderma($daysSinceLastTrichoderma, $daysSinceLastFertilizer)) {
            return $this->createWateringResponse($nextWateringDate, false, true);
        }
        return $this->createWateringResponse($nextWateringDate, false, false);
    }
    private function shouldSuggestFertilizer(?int $daysSinceLastFertilizer, ?int $daysSinceLastTrichoderma): bool
    {
        return ($daysSinceLastFertilizer === null && $daysSinceLastTrichoderma >= $this->fertilizerInterval) ||
            ($daysSinceLastFertilizer !== null && $daysSinceLastTrichoderma !== null &&
                $daysSinceLastTrichoderma < $daysSinceLastFertilizer &&
                $daysSinceLastTrichoderma >= $this->fertilizerInterval);
    }
    private function shouldSuggestTrichoderma(?int $daysSinceLastTrichoderma, ?int $daysSinceLastFertilizer): bool
    {
        return ($daysSinceLastTrichoderma === null && $daysSinceLastFertilizer >= $this->trichodermaInterval) ||
            ($daysSinceLastFertilizer !== null && $daysSinceLastTrichoderma !== null &&
                $daysSinceLastFertilizer < $daysSinceLastTrichoderma &&
                $daysSinceLastFertilizer >= $this->trichodermaInterval);
    }
    private function getDaysSinceLastTreatment(?Carbon $lastDate, Carbon $referenceDate): ?int
    {
        return $lastDate ? $lastDate->diffInDays($referenceDate) : null;
    }
    private function createWateringResponse(Carbon $date, bool $withFertilizer, bool $withTrichoderma): array
    {
        return [
            'date' => $date->format('Y-m-d'),
            'with_fertilizer' => $withFertilizer,
            'with_trichoderma' => $withTrichoderma
        ];
    }
    public function getNextWateringDate(): ?array
    {
        return $this->calculateNextWateringDate();
    }
    public function calculateAverageInterval(): ?float
    {
        return $this->averageInterval;
    }
}
