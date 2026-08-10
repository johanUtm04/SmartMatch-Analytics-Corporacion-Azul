<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'surface_type',
        'consumption_per_m2',
        'min_coverage_m2',
        'max_coverage_m2',
    ];

    protected $casts = [
        'consumption_per_m2' => 'decimal:2',
        'min_coverage_m2' => 'decimal:2',
        'max_coverage_m2' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}