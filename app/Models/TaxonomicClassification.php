<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxonomicClassification extends Model
{
    /** @use HasFactory<\Database\Factories\TaxonomicClassificationFactory> */
    use HasFactory;

    protected $fillable = [
        'kingdom',
        'division',
        'class',
        'order',
        'family',
        'genus'
    ];

    public function plants(): HasMany
    {
        return $this->hasMany(Plant::class);
    }
}
