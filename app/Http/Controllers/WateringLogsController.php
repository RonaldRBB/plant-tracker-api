<?php

namespace App\Http\Controllers;

use App\Models\WateringLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WateringLogsController extends Controller
{
    protected array $rules = [
        'user_plant_id' => 'required|exists:user_plants,id',
        'watering_date' => 'required|date',
        'watering_method' => 'required|in:immersion,surface,spraying',
        'with_fertilizer' => 'boolean',
        'with_trichoderma' => 'boolean',
        'with_slow_release' => 'boolean',
    ];
    public function __construct(WateringLog $model)
    {
        parent::__construct($model);
    }
    public function index(Request $request): JsonResponse
    {
        return $this->indexResource($request);
    }
    public function show(Request $request, WateringLog $wateringLog): JsonResponse
    {
        return $this->showResource($request, $wateringLog);
    }
    public function store(Request $request): JsonResponse
    {
        return $this->storeResource($request);
    }
    public function update(Request $request, WateringLog $wateringLog): JsonResponse
    {
        return $this->updateResource($request, $wateringLog);
    }
    public function destroy(Request $request, WateringLog $wateringLog): JsonResponse
    {
        return $this->destroyResource($wateringLog);
    }
}
