<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Billing\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. User Growth (Last 30 days)
        $users = User::selectRaw('DATE(created_at) as date, count(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $growthData = [
            'labels' => $users->pluck('date'),
            'data' => $users->pluck('count'),
        ];

        // 2. Sales (Last 6 months)
        $sales = Subscription::selectRaw('strftime("%Y-%m", created_at) as month, sum(amount) as total')
            ->where('status', 'active') // Assuming active means paid/valid sales for simplicity
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $salesData = [
            'labels' => $sales->pluck('month'),
            'data' => $sales->pluck('total'),
        ];

        // 3. Churn Rate (Simple calculation: Inactive / Total)
        $totalUsers = User::count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $churnRate = $totalUsers > 0 ? round(($inactiveUsers / $totalUsers) * 100, 1) : 0;

        return view('admin::dashboard', compact('growthData', 'salesData', 'churnRate', 'totalUsers', 'inactiveUsers'));
    }
}
