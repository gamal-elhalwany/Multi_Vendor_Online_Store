<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index (Request $request) {
        $products = Product::filter($request->all())->orderBy('name')
        ->active()
        ->with('category')
        ->latest()
        // ->limit(8) this doesn't work with filter scope.
        ->paginate(12);

        return view('front.home', compact('products'));
    }

    public function category (Category $category)
    {
        return view('front.category', compact('category'));
    }

    public function aboutUs ()
    {
        return view('front.about-us');
    }

    public function contactUs ()
    {
        return view('front.contact-us');
    }
}
