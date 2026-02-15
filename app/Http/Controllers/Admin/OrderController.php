<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\InvoiceService;
use App\Services\StatusTransitionService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer', 'items.piano');

        if ($request->filled('status')) {
            $query->status($request->status);
        }

        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('customer', 'items.piano', 'payments', 'invoices', 'deliveryTasks', 'activityLogs');
        $allowedTransitions = config('piano_statuses.order.transitions.' . $order->status, []);
        return view('admin.orders.show', compact('order', 'allowedTransitions'));
    }

    public function updateStatus(Request $request, Order $order, StatusTransitionService $transitionService)
    {
        $request->validate(['status' => 'required|string']);

        try {
            $transitionService->transition($order, $request->status, 'order');
            return back()->with('success', 'Order status updated to ' . ucfirst(str_replace('_', ' ', $request->status)) . '.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function generateInvoice(Order $order, InvoiceService $invoiceService)
    {
        try {
            $invoiceService->createForOrder($order);
            return back()->with('success', 'Invoice generated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
