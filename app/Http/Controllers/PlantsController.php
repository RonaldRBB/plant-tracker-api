<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlantsController extends Controller
{
    protected array $rules = [
        'scientific_name' => 'required|string|max:255',
        'common_name' => 'required|string|max:255',
        'dli' => 'nullable|integer',
        'taxonomic_classification_id' => 'required|exists:taxonomic_classifications,id'
    ];
    public function __construct(Plant $model)
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
    public function show(Request $request, Plant $plant): JsonResponse
    {
        return $this->showResource($request, $plant);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plant $plant)
    {
        return $this->updateResource($request, $plant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plant $plant)
    {
        return $this->destroyResource($plant);
    }
}
