<?php

namespace App\Http\Controllers;

use App\Models\UserPlant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserPlantsController extends Controller
{
    protected array $loadRelations = [
        'user',
        'plant',
        'plant.taxonomicClassification',
        'wateringLogs'
    ];
    protected array $rules = [
        'plant_id' => 'required|exists:plants,id',
        'user_id' => 'required|exists:users,id',
        'nickname' => 'nullable|string',
        'location' => 'nullable|string',
        'notes' => 'nullable|string',
        'acquired_date' => 'nullable|date',
        'death_date' => 'nullable|date',
        'mycorrhiza' => 'nullable|boolean',
        'mycorrhiza_date' => 'nullable|date',
    ];
    public function __construct(UserPlant $model)
    {
        parent::__construct($model);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return $this->indexResource($request);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->storeResource($request);
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, UserPlant $userPlant): JsonResponse
    {
        $userPlant->load($this->loadRelations);
        return $this->showResource($request, $userPlant);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserPlant $userPlant)
    {
        return $this->updateResource($request, $userPlant);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPlant $userPlant): JsonResponse
    {
        return $this->destroyResource($userPlant);
    }
}
