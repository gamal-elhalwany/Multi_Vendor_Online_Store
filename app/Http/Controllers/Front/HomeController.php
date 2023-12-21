<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index (Request $request) {
        $products = Product::filter($request->all())
        // ->orderBy('name')
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

    public function sendContactEmail(Request $request)
    {
        $contactContent = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:3',
            'phone' => 'required|numeric|min:11',
        ]);

        Mail::to('g@all.com')->send(new ContactMail($contactContent));

        return redirect('/contact-us')->with('success', 'Your Email has been Sent Successfully.');
    }
}
