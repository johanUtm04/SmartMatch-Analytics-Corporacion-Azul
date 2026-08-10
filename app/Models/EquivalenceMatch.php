<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquivalenceMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'own_product_id',
        'competitor_product_id',
        'match_type',
        'gama',
        'technical_segmentation',
        'strategic_analysis',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'priority' => 'integer',
        'is_active' => 'boolean',
    ];

    public function ownProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'own_product_id');
    }

    public function competitorProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'competitor_product_id');
    }
}