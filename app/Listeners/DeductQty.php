<?php

namespace App\Listeners;

use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class DeductQty
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
        try {
            foreach ($this->cart->get() as $item) {
                Product::where('id', '=', $item->product_id)->update([
                    'qty' => DB::raw('qty - ' . $item->quantity),
                ]);
            }
        } catch (\Throwable $e) {

        }
    }
}
