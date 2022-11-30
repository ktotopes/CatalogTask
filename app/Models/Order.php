<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends MainModel
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->number = Str::random(8);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'basket_items');
    }
}
