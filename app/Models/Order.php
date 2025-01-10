<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shipping_address(): BelongsTo
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    /**
     * Get all of the order_descriptions for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order_descriptions(): HasMany
    {
        return $this->hasMany(OrderDescription::class);
    }
}
