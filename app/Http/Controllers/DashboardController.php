<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\CancelRequest;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /* -------------------------------
           Monthly Revenue (Current Year)
        -------------------------------- */
        $monthlyRevenueCollection = DB::table('invoices')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'paid')
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

        // Initialize all months to 0
        $monthlyRevenue = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyRevenue[$m] = $monthlyRevenueCollection[$m] ?? 0;
        }

        /* -------------------------------
           Daily Revenue (Current Month)
        -------------------------------- */
        $dailyRevenueCollection = DB::table('invoices')
            ->select(
                DB::raw('DAY(created_at) as day'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'paid')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->orderBy(DB::raw('DAY(created_at)'))
            ->pluck('total', 'day');

        // Get total days in current month
        $daysInMonth = now()->daysInMonth;

        // Initialize all days to 0
        $dailyRevenue = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dailyRevenue[$d] = $dailyRevenueCollection[$d] ?? 0;
        }

        /* -------------------------------
           Other Dashboard Data
        -------------------------------- */
        $totalCancels = CancelRequest::count();
        $recentCancels = CancelRequest::latest()->take(5)->get();

        return view('dashboard.index', [
            'totalTrips'       => Trip::count(),
            'totalCustomers'   => Customer::count(),
            'totalInvoices'    => Invoice::count(),
            'totalRevenue'     => Invoice::where('status', 'paid')->sum('amount'),
            'pendingInvoices'  => Invoice::where('status', 'pending')->count(),
            'recentInvoices'   => Invoice::latest()->take(5)->get(),

            'monthlyRevenue'   => array_values($monthlyRevenue),
            'dailyRevenue'     => array_values($dailyRevenue),

            'totalCancels'     => $totalCancels,
            'recentCancels'    => $recentCancels,
        ]);
    }
}
