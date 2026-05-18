<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    protected $fillable = ['vendor_id', 'invoice_no', 'purchase_date', 'subtotal', 'tax', 'freight', 'total', 'notes'];

    protected $casts = [
        'purchase_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'freight' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
