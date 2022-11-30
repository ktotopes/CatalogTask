<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Basket;
use App\Http\Requests\OrderRequest;

class OrderController extends MainController
{
    public function index()
    {
        return $this->jsonSuccess([
            'items' => auth()->user()?->orders
        ]);
    }

    public function checkout(OrderRequest $request, Basket $basket)
    {
        if (!$basket->items()->count()) {
            return $this->jsonError(status: 422, message: 'You do not have any items in basket.');
        }

        $order = new Order([
            ...$request->validated(),
            ...[
                'user_id' => $request->user()?->id,
            ],
        ]);
        $order->save();

        $total = 0;

        foreach ($basket->items as $item) {
            $total += ($item->quantity * $item->product->price);

            $item->update([
                'basket_id' => null,
                'order_id'  => $order->id,
            ]);
        }

        $order->update(['total' => $total]);

        return $this->jsonSuccess([
            'order_number' => $order->number,
        ], 201);
    }
}
