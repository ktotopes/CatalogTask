<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Response;

class BasketController extends Controller
{
    use Response;

    protected Basket $activeBasket;

    public function index()
    {
        return $this->jsonSuccess([
            'items' => activeBasket()->items->load('product'),
        ]);
    }

    public function store(Product $product)
    {
        $this->activeBasket = activeBasket();

        if ($this->activeBasket->products->contains($product)) {
            return $this->jsonError(
                status: 422,
                message: 'Product already in basket.',
            );
        }

        $this->activeBasket->addProduct($product);

        return $this->jsonSuccess(status: 201);

    }

    public function updateQuantity(Item $item, int $quantity)
    {
        if (!$item->basket_id) {
            return $this->jsonError(
                status: 404,
                message: 'Item not found.',
            );
        }
        
        if ($quantity < 1) {
            return $this->jsonError(
                status: 422,
                errors: ['quantity' => 'Value should be more then 1'],
                message: 'Data was incorrect.',
            );
        }

        $item->update(['quantity' => $quantity]);

        return $this->jsonSuccess();
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return $this->jsonSuccess();
    }
}
