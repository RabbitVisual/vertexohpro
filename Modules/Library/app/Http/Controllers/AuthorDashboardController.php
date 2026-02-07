<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Billing\Models\MaterialPurchase;

class AuthorDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Total sales from resources owned by the user
        $totalSales = MaterialPurchase::whereHas('resource', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('amount');

        // Available Balance (assuming 10% platform fee)
        $availableBalance = $totalSales * 0.90;

        // Sales history
        $salesHistory = MaterialPurchase::whereHas('resource', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['user', 'resource'])->latest()->paginate(10);

        return view('library::author.dashboard', compact('totalSales', 'availableBalance', 'salesHistory'));
    }
}
