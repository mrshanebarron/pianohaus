<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Piano;
use App\Models\Rental;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Revenue summary
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $salesRevenue = Payment::where('status', 'completed')->where('type', 'purchase')->sum('amount');
        $rentalRevenue = Payment::where('status', 'completed')->whereIn('type', ['rental_deposit', 'rental_monthly'])->sum('amount');

        // Inventory summary
        $inventoryValue = Piano::available()->sum('sale_price');
        $inventoryByCategory = Piano::selectRaw('categories.name, count(*) as count, sum(pianos.sale_price) as total_value')
            ->join('categories', 'pianos.category_id', '=', 'categories.id')
            ->where('pianos.status', 'available')
            ->groupBy('categories.name')
            ->get();

        $inventoryByBrand = Piano::selectRaw('brands.name, count(*) as count')
            ->join('brands', 'pianos.brand_id', '=', 'brands.id')
            ->groupBy('brands.name')
            ->get();

        // Monthly revenue chart data
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Payment::where('status', 'completed')
                ->whereYear('paid_at', $date->year)
                ->whereMonth('paid_at', $date->month)
                ->sum('amount');
            $monthlyRevenue[] = [
                'month' => $date->format('M Y'),
                'revenue' => $revenue / 100,
            ];
        }

        // Rental stats
        $activeRentals = Rental::active()->count();
        $avgRentalDuration = Rental::where('status', 'completed')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->get()
            ->avg(fn ($r) => $r->start_date->diffInMonths($r->end_date));

        return view('admin.reports.index', compact(
            'totalRevenue', 'salesRevenue', 'rentalRevenue',
            'inventoryValue', 'inventoryByCategory', 'inventoryByBrand',
            'monthlyRevenue', 'activeRentals', 'avgRentalDuration'
        ));
    }
}
