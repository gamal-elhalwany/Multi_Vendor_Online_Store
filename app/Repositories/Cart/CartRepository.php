<?php

namespace App\Repositories\Cart;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

interface CartRepository
{
    public function get () : Collection;

    public function add (Product $product, $quantity = 1);

    public function update (Product $product, $quantity);

    public function delete ($id);

    public function empty ();

    public function total ($quantity) : float;
}
