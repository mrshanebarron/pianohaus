<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Services\ContractService;
use App\Services\RentalService;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with('customer', 'piano');

        if ($request->filled('status')) {
            $query->status($request->status);
        }

        $rentals = $query->latest()->paginate(15);
        return view('admin.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load('customer', 'piano', 'payments', 'contract', 'deliveryTasks', 'activityLogs');
        return view('admin.rentals.show', compact('rental'));
    }

    public function approve(Rental $rental, RentalService $rentalService)
    {
        try {
            $rentalService->approve($rental, auth()->id());
            return back()->with('success', 'Rental application approved.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deny(Request $request, Rental $rental, RentalService $rentalService)
    {
        try {
            $rentalService->deny($rental, $request->input('reason', ''));
            return back()->with('success', 'Rental application denied.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function generateContract(Rental $rental, ContractService $contractService)
    {
        try {
            $contractService->createForRental($rental);
            return back()->with('success', 'Contract generated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
