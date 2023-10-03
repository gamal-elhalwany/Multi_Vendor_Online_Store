<?php

namespace App\Listeners;

use App\Repositories\Cart\CartRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmptyCart
{
    public $cart;
    /**
     * Create the event listener.
     */
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Handle the event.
     */
    public function handle(): void
    {
        $this->cart->empty();
    }
}
