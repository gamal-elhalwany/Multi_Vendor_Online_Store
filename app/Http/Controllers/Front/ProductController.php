<?php

namespace App\Http\Controllers\Front;

use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request, Product $product)
    {
        $user = auth()->user();
        if ($user) {
            $products = Product::filter($request->all())->active()->with('ratings')->latest()->paginate(12);
            return view('front.products.index', compact('products'));
        }
        return redirect()->route('login');
    }

    public function show(Product $product)
    {
        $user = auth()->user();
        if ($user) {
            if ($product->status != 'active') {
                abort(404);
            }
            return view('front.products.show', compact('product'));
        }
        return redirect()->route('login');
    }

    public function filterByRange(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $rangeValue = $request->input('range_value');
            $products = Product::where('price', '<=', $rangeValue)->paginate();
            return view('front.products.index', compact('products'));
        }
        return redirect()->route('login');
    }

    public function sortProducts(Request $request)
    {
        $selectedCriteria = $request->input('criteria');

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

    public function add_rating(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            if ($user->ratings) {
                $rating = Rating::where('product_id', $request->product_id)->where('user_id', $user->id)->first();
                if ($rating) {
                    return redirect()->back()->with('error', 'You have already Rated this Product!');
                } else {
                    Rating::create([
                        'user_id' => auth()->id(),
                        'product_id' => $request->product_id,
                        'rating' => $request->rating,
                        'review' => $request->review,
                    ]);
                }
            }
        } else {
            return redirect()->route('login');
        }
        return redirect()->back()->with('success', 'You have Rated this product successfully!');
    }
}