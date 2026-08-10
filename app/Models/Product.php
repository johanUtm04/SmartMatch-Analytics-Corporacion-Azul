<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'sku',
        'erp_name',
        'technical_name',
        'guarantee_years',
        'volume_liters',
        'base_type',
        'is_fibrated',
        'requires_separate_primer',
    ];

    protected $casts = [
        'volume_liters' => 'decimal:2',
        'is_fibrated' => 'boolean',
        'requires_separate_primer' => 'boolean',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function performances(): HasMany
    {
        return $this->hasMany(ProductPerformance::class);
    }

    // Equivalencias donde este producto es el "propio" (own_product_id)
    public function equivalenceMatchesAsOwn(): HasMany
    {
        return $this->hasMany(EquivalenceMatch::class, 'own_product_id');
    }

    // Equivalencias donde este producto es el "competidor"
    public function equivalenceMatchesAsCompetitor(): HasMany
    {
        return $this->hasMany(EquivalenceMatch::class, 'competitor_product_id');
    }

    public function latestPrice()
    {
        return $this->hasOne(ProductPrice::class)->latestOfMany('registered_at');
    }
}