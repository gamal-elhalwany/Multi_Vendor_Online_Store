<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    public function get(): Collection
    {
        $authID = auth()->id();
        return Cart::with('product')
            ->where('user_id', '=', $authID)->get();
    }

    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id', '=', $product->id)
            ->where('cookie_id', '=', $this->getCookieId())->first();

        if (!$item) {
            return Cart::create([
                'cookie_id' => $this->getCookieId(),
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }
        return $item->increment('quantity', $quantity);
    }

    public function update(Product $product, $quantity)
    {
        $authID = auth()->id();
        return Cart::where('product_id', '=', $product->id)
            ->where('user_id', '=', $authID)
            ->update([
                'quantity' => $quantity,
            ]);
    }

    public function delete($id)
    {
        $authID = auth()->id();
        return Cart::where('id', '=', $id)
            ->where('user_id', '=', $authID)
            ->delete();
    }

    public function empty()
    {
        return Cart::where('cookie_id', '=', $this->getCookieId())->delete();
    }

    public function total($quantity): float
    {
        $authID = auth()->id();
        return (float) Cart::where('user_id', '=', $authID)->join('products', 'products.id', '=', 'carts.product_id')->selectRaw('SUM(products.price * carts.quantity) as total')->value('total');
    }

    protected function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 60 * 24 * 7);
        }
        return $cookie_id;
    }
}
