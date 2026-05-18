<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['sku', 'name', 'category', 'category_id', 'brand_id', 'unit', 'selling_price', 'reorder_level'];

    protected $casts = [
        'selling_price' => 'decimal:2',
        'reorder_level' => 'integer',
    ];

    public function vendorPrices(): HasMany
    {
        return $this->hasMany(VendorProductPrice::class);
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function getCurrentStockAttribute(): int
    {
        return (int) $this->stockMovements()->sum('quantity');
    }

    public function getAverageCostAttribute(): float
    {
        $items = $this->purchaseItems();
        $qty = (int) $items->sum('quantity');

        return $qty > 0 ? (float) $items->sum('line_total') / $qty : 0.0;
    }

    public function getStockWorthAttribute(): float
    {
        return $this->current_stock * $this->average_cost;
    }

    public function getMarginAttribute(): float
    {
        return (float) $this->selling_price - $this->average_cost;
    }

    public function getExpectedProfitAttribute(): float
    {
        return $this->current_stock * $this->margin;
    }
}
