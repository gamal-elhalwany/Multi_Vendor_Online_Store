<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $coupons = Coupon::with('stores')->get();
        // $storesWithCoupons = Store::with('coupon')->get();

        // dd($stores);

        if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            return view('dashboard.coupons.index', compact('coupons'));
        }
        return redirect()->route('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $stores = Store::where('user_id', '=', $user->id)->get();
        if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            return view('dashboard.coupons.create', compact('stores'));
        }
        return redirect(route('login'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'type' => ['required', 'in:persentage,fixed'],
            'store_id' => ['required', 'exists:stores,id'],
            'max_uses' => ['required', 'numeric'],
            'user_max_uses' => ['required', 'numeric'],
            'status' => ['nullable'],
            'start_at' => ['required', 'date', 'after_or_equal:today'],
            'end_at' => ['required', 'date', 'after:start_at'],
        ]);

        $counpon = Coupon::create($request->all());
        return redirect()->route('coupons.index')->with('success', 'Coupon is successfully added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
