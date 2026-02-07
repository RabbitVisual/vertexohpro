<?php

namespace Modules\Billing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Billing\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::where('user_id', Auth::id())->paginate(10);
        return view('billing::coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('billing::coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons|max:50',
            'discount_percent' => 'required|integer|min:1|max:100',
            'valid_until' => 'nullable|date|after:today',
        ]);

        Coupon::create([
            'user_id' => Auth::id(),
            'code' => strtoupper($validated['code']),
            'discount_percent' => $validated['discount_percent'],
            'valid_until' => $validated['valid_until'],
        ]);

        return redirect()->route('coupons.index')->with('success', 'Cupom criado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $coupon = Coupon::where('user_id', Auth::id())->findOrFail($id);
        $coupon->delete();

        return redirect()->route('coupons.index')->with('success', 'Cupom removido.');
    }
}
