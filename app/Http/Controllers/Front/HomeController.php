<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index () {
        $products = Product::active()->with('category')->latest()->limit(8)->get();
        return view('front.home', compact('products'));
    }

    public function category (Category $category)
    {
        return "This is Category Page " . $category->id;
    }
}
