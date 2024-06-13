<?php

namespace App\Http\Controllers\Front;

use Spatie\Newsletter\Facades\Newsletter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->input('email');
        if (Newsletter::isSubscribed($email)) {
            return redirect()->back()->with('error', 'You have already subcribed to our newsletter.');
        }
        Newsletter::subscribe($email);
        return redirect()->back()->with('success', 'You have successfully subscribed to our newsletters.');
    }
}
