<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $child;
    public function index (Request $request) {
        $products = Product::filter($request->all())->orderBy('name')
        ->active()
        ->with('category')
        ->latest()
        // ->limit(8)
        ->paginate();

        return view('front.home', compact('products'));
    }

    public function show (Category $category)
    {
        return "This is the Category Page " . $category->id;
    }
}
