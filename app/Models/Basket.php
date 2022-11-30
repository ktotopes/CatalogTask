<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Basket extends MainModel
{
    public function addProduct(Product $product)
    {
        Item::create([
            'basket_id'  => $this->id,
            'product_id' => $product->id,
        ]);
    }

    public function getBasketItemByProduct(Product $product): Item
    {
        return Item::where('basket_id', activeBasket()->id)->where('product_id', $product->id)->first();
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
        return $this->belongsToMany(Product::class, 'items');
    }
}
