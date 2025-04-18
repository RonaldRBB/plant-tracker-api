<?php

namespace App\Http\Controllers;

use App\Models\TaxonomicClassification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaxonomicClassificationController extends Controller
{
    protected array $rules = [
        'kingdom' => 'required|string|max:255',
        'division' => 'required|string|max:255',
        'class' => 'required|string|max:255',
        'order' => 'required|string|max:255',
        'family' => 'required|string|max:255',
        'genus' => 'required|string|max:255',
    ];

    public function __construct(TaxonomicClassification $model)
    {
        parent::__construct($model);
    }

    public function index(Request $request): JsonResponse
    {
        return $this->indexResource($request);
    }

    public function store(Request $request)
    {
        $rules = $this->rules;
        $rules['genus'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('taxonomic_classifications')
                ->where(function ($query) use ($request) {
                    return $query->where('kingdom', $request->kingdom)
                        ->where('division', $request->division)
                        ->where('class', $request->class)
                        ->where('order', $request->order)
                        ->where('family', $request->family);
                })
        ];

        $request->validate($rules);
        return $this->storeResource($request);
    }

    public function show(Request $request, TaxonomicClassification $taxonomicClassification): JsonResponse
    {
        return $this->showResource($request, $taxonomicClassification);
    }

    public function update(Request $request, TaxonomicClassification $taxonomicClassification)
    {
        $rules = $this->rules;
        $rules['genus'] = [
            'required',
            'string',
            'max:255',
            Rule::unique('taxonomic_classifications')
                ->where(function ($query) use ($request) {
                    return $query->where('kingdom', $request->kingdom)
                        ->where('division', $request->division)
                        ->where('class', $request->class)
                        ->where('order', $request->order)
                        ->where('family', $request->family);
                })
                ->ignore($taxonomicClassification->id)
        ];

        $request->validate($rules);
        return $this->updateResource($request, $taxonomicClassification);
    }

    public function destroy(TaxonomicClassification $taxonomicClassification)
    {
        return $this->destroyResource($taxonomicClassification);
    }
}
