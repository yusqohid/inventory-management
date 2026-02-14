<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'sku',
        'name',
        'description',
        'purchase_price',
        'sale_price',
        'quantity',
        'alert_threshold'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    // Helper: Check if stock is low
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->alert_threshold;
    }

    // Auto generate SKU
    protected static function booted()
    {
        static::creating(function ($product) {
            if (!$product->sku) {
                $product->sku = 'PRD-' . strtoupper(uniqid());
            }
        });
    }
}
