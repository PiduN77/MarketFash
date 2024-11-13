<?php

namespace App\Http\ViewComposers;

use App\Models\Cart;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CartComposer
{
    public function compose(View $view)
    {
        $cartCount = null;
        $cart = null;

        if (Auth::check()) {
            $cartCount = Cart::firstOrCreate([
                'customer_id' => Auth::user()->customers->customer_id
            ]);

            $cart = Cart::where('customer_id', Auth::user()->customers->customer_id)
                ->with(['cartItem' => function ($query) {
                    $query->take(3);
                    $query->with(['variationSize.photo.variation.product']);
                }])
                ->first();
        }

        $view->with('cartCount', $cartCount);
        $view->with('cart', $cart);
    }
}