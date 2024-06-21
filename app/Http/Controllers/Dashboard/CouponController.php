<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-coupon', ['only' => ['index']]);
        $this->middleware('permission:create-coupon', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-coupon', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-coupon', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $coupons = Coupon::with('stores')->get();

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
            'type' => ['required', 'in:percent,fixed'],
            'store_id' => ['required', 'exists:stores,id'],
            'user_id' => ['required', 'exists:users,id'],
            'max_uses' => ['required', 'numeric'],
            'user_max_uses' => ['required', 'numeric'],
            'discount_amount' => ['required', 'numeric'],
            'status' => ['required'],
            'start_at' => ['required', 'date', 'after_or_equal:today'],
            'end_at' => ['required', 'date', 'after:start_at'],
        ]);

        $user = auth()->user();
        if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            $coupon = Coupon::create($request->all());
            return redirect()->route('coupons.index')->with('success', 'Coupon is successfully added!');
        }
        return redirect()->route('login');
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
        $user = auth()->user();
        $stores = Store::where('user_id', '=', $user->id)->get();
        $coupon = Coupon::findOrFail($id);
        if ($user && $user->hasAnyRole('Owner', 'Super-admin')) {
            return view('dashboard.coupons.edit', compact('stores', 'coupon'));
        }
        return redirect(route('login'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'code' => ['required', 'string'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'type' => ['required', 'in:percent,fixed'],
            'store_id' => ['required', 'exists:stores,id'],
            'user_id' => ['required', 'exists:users,id'],
            'max_uses' => ['required', 'numeric'],
            'user_max_uses' => ['required', 'numeric'],
            'discount_amount' => ['required', 'numeric'],
            'status' => ['required'],
            'start_at' => ['required', 'date', 'after_or_equal:today'],
            'end_at' => ['required', 'date', 'after:start_at'],
        ]);

        $user = auth()->user();

        if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            $coupon = Coupon::findOrFail($id);
            $coupon->update($request->all());
            return redirect()->route('coupons.index')->with('success', 'Coupon is successfully updated!');
        }
        return redirect(route('login'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->user();
        if ($user && $user->hasAnyRole('Owner', 'Super-admin')) {
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();
            return redirect(route('coupons.index'))->with('success', "The coupon has been deleted!");
        }
        return redirect(route('login'));
    }
}
