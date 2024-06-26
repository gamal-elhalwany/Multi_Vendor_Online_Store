<?php

namespace App\View\Components;

use App\Models\Order;
use App\Repositories\Cart\CartRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartMenu extends Component
{
    public $items;
    public $total;
    /**
     * Create a new component instance.
     */
    public function __construct(CartRepository $cart, Order $order)
    {
        $this->items = $cart->get();
        $this->total = $cart->total($quantity = 1);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-menu');
    }
}
