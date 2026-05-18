<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorProductPrice extends Model
{
    protected $fillable = ['vendor_id', 'product_id', 'price', 'lead_time_days', 'effective_from'];

    protected $casts = [
        'price' => 'decimal:2',
        'lead_time_days' => 'integer',
        'effective_from' => 'date',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
