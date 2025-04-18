<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plant extends BaseModel
{
    /** @use HasFactory<\Database\Factories\PlantFactory> */
    use HasFactory;
    protected $fillable = [
        'scientific_name',
        'common_name',
        'dli',
        'taxonomic_classification_id'
    ];

    public function taxonomicClassification(): BelongsTo
    {
        return $this->belongsTo(TaxonomicClassification::class);
    }
}
