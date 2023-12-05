<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index (Request $request) {
        $products = Product::filter($request->all())->orderBy('name')
        ->active()
        ->with('category')
        ->latest()
        // ->limit(8) this doesn't work with filter scope.
        ->paginate();

        return view('front.home', compact('products'));
    }

    public function show (Category $category)
    {
        return "This is the Category Page " . $category->id ." $category->name";
    }
}
