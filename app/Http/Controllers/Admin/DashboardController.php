<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\LedgerEntry;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Piano;
use App\Models\Rental;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pianos' => Piano::count(),
            'available_pianos' => Piano::available()->count(),
            'active_rentals' => Rental::active()->count(),
            'pending_applications' => Rental::pending()->count(),
            'pending_orders' => Order::status('pending')->count(),
            'pending_reviews' => Review::where('is_approved', false)->count(),
            'total_customers' => Customer::count(),
            'monthly_revenue' => Payment::where('status', 'completed')
                ->where('paid_at', '>=', now()->startOfMonth())
                ->sum('amount'),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
        ];

        $recentOrders = Order::with('customer', 'items.piano')
            ->latest()
            ->take(5)
            ->get();

        $pendingRentals = Rental::with('customer', 'piano')
            ->pending()
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with('customer')
            ->where('status', 'completed')
            ->latest('paid_at')
            ->take(5)
            ->get();

        // Revenue by month (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Payment::where('status', 'completed')
                ->whereYear('paid_at', $date->year)
                ->whereMonth('paid_at', $date->month)
                ->sum('amount');
            $monthlyRevenue[] = [
                'month' => $date->format('M'),
                'revenue' => $revenue / 100,
            ];
        }

        // Inventory breakdown
        $inventoryBreakdown = Piano::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.dashboard', compact(
            'stats', 'recentOrders', 'pendingRentals', 'recentPayments',
            'monthlyRevenue', 'inventoryBreakdown'
        ));
    }
}
