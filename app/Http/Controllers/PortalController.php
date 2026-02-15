<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    protected function getCustomer()
    {
        return auth()->user()->customer;
    }

    public function dashboard()
    {
        $customer = $this->getCustomer();

        if (!$customer) {
            return view('portal.dashboard', [
                'activeRentals' => collect(),
                'recentOrders' => collect(),
                'nextPaymentDue' => null,
                'totalSpent' => 0,
                'stats' => ['orders' => 0, 'rentals' => 0, 'documents' => 0],
            ]);
        }

        $activeRentals = $customer->rentals()->with('piano')->active()->latest()->take(3)->get();
        $recentOrders = $customer->orders()->with('items.piano')->latest()->take(5)->get();

        $nextPaymentDue = $customer->invoices()
            ->whereIn('status', ['sent', 'overdue'])
            ->orderBy('due_date')
            ->first();

        $stats = [
            'orders' => $customer->orders()->count(),
            'rentals' => $customer->rentals()->count(),
            'documents' => $customer->contracts()->count() + $customer->invoices()->count(),
        ];

        return view('portal.dashboard', compact('customer', 'activeRentals', 'recentOrders', 'nextPaymentDue', 'stats'));
    }

    public function orders()
    {
        $customer = $this->getCustomer();
        $orders = $customer
            ? $customer->orders()->with('items.piano')->latest()->paginate(10)
            : collect();

        return view('portal.orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        $customer = $this->getCustomer();
        abort_unless($customer && $order->customer_id === $customer->id, 403);

        $order->load('items.piano', 'payments', 'invoices', 'deliveryTasks');
        return view('portal.order-detail', compact('order'));
    }

    public function rentals()
    {
        $customer = $this->getCustomer();
        $rentals = $customer
            ? $customer->rentals()->with('piano')->latest()->paginate(10)
            : collect();

        return view('portal.rentals', compact('rentals'));
    }

    public function rentalDetail(Rental $rental)
    {
        $customer = $this->getCustomer();
        abort_unless($customer && $rental->customer_id === $customer->id, 403);

        $rental->load('piano', 'payments', 'contract', 'invoices', 'deliveryTasks');
        return view('portal.rental-detail', compact('rental'));
    }

    public function payments()
    {
        $customer = $this->getCustomer();
        $payments = $customer
            ? $customer->payments()->with('order', 'rental')->latest()->paginate(15)
            : collect();

        return view('portal.payments', compact('payments'));
    }

    public function documents()
    {
        $customer = $this->getCustomer();

        if ($customer) {
            $contracts = $customer->contracts()->with('rental.piano')->latest()->get();
            $invoices = $customer->invoices()->with('order', 'rental')->latest()->get();
        } else {
            $contracts = collect();
            $invoices = collect();
        }

        return view('portal.documents', compact('contracts', 'invoices'));
    }

    public function profile()
    {
        $customer = $this->getCustomer();
        return view('portal.profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $customer = $this->getCustomer();
        abort_unless($customer, 403);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:20',
        ]);

        $customer->update($validated);

        if ($request->filled('email')) {
            auth()->user()->update(['email' => $request->email]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}
