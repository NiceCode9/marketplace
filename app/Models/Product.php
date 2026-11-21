<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'brand_id', 'category_id', 'sku', 'name', 'slug', 'description', 'price',
        'stock', 'weight', 'unit', 'status', 'allow_backorder',
        'sim_type', 'sim_coverage', 'sim_units_per_pack', 'sim_waste_percent', 'sim_rounding',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'decimal:3',
        'allow_backorder' => 'boolean',
        'sim_coverage' => 'decimal:4',
        'sim_waste_percent' => 'decimal:2',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function specs(): HasMany
    {
        return $this->hasMany(ProductSpec::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function simulationLogs(): HasMany
    {
        return $this->hasMany(SimulationLog::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }
}