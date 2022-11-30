<?php


use App\Models\User;
use App\Models\Basket;
use Illuminate\Support\Facades\Auth;

if (!function_exists('user')) {
    function user(): ?User
    {
        return Auth::user() ?? null;
    }
}

if (!function_exists('activeBasket')) {
    function activeBasket(): Basket
    {
        $basketKey = sha1(request()->userAgent() . request()->ip());

        if (Cache::has($basketKey) && ($basket = Basket::find(cache($basketKey)))) {
            return $basket;
        }

        $basket = new Basket();
        $basket->user_id = request()->user()?->id ?? null;
        $basket->save();

        Cache::forever($basketKey, $basket->id);

        return $basket;
    }
}


