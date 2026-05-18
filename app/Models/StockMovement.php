<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = ['product_id', 'purchase_item_id', 'type', 'quantity', 'unit_cost', 'movement_date', 'reference', 'notes'];

    protected $casts = [
        'quantity' => 'integer',
        'unit_cost' => 'decimal:2',
        'movement_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function purchaseItem(): BelongsTo
    {
        return $this->belongsTo(PurchaseItem::class);
    }
}
