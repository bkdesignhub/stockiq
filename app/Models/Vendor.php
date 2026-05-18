<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    protected $fillable = ['name', 'contact_person', 'phone', 'email', 'address'];

    public function prices(): HasMany
    {
        return $this->hasMany(VendorProductPrice::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
