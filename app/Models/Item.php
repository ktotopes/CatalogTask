<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends MainModel
{
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function basket(): BelongsTo
    {
        return $this->belongsTo(Basket::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
