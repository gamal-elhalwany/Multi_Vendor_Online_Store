<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index (Request $request) {
        $products = Product::filter($request->all())->active()->latest()->paginate(12);
        return view('front.products.index', compact('products'));
    }

    public function show (Product $product) {
        if ($product->status != 'active') {
            abort(404);
        }
        return view('front.products.show', compact('product'));
    }

    public function filterByRange(Request $request)
    {
        $rangeValue = $request->input('range_value');
        $products = Product::where('price', '<=', $rangeValue)->paginate();
        return view('front.products.index', compact('products'));
    }

    public function sortProducts(Request $request)
    {
        $selectedCriteria = $request->input('criteria');
        // $products = Product::orderBy($selectedCriteria)->paginate();
        dd($selectedCriteria);

        switch ($selectedCriteria) {
            case 'low_high':
                $products = Product::orderBy('price', 'asc')->paginate();
                break;
            case 'high_low':
                $products = Product::orderBy('price', 'desc')->paginate();
                break;
            case 'a_z':
                $products = Product::orderBy('name', 'asc')->paginate();
                break;
            case 'z_a':
                $products = Product::orderBy('name', 'desc')->paginate();
                break;
            default:
                $products = Product::paginate();
                break;
        }

        return view('front.products.index', compact('products'));
    }
}
