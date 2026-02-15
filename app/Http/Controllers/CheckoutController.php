<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cart,
        private OrderService $orderService,
    ) {}

    public function index()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('catalog')->with('error', 'Your cart is empty.');
        }

        $items = collect($this->cart->items());

        return view('storefront.checkout', [
            'items' => $items,
            'subtotal' => $this->cart->formattedSubtotal(),
            'tax' => $this->cart->formattedTax(),
            'deliveryFee' => $this->cart->formattedDeliveryFee(),
            'total' => $this->cart->formattedTotal(),
            'totalCents' => $this->cart->total(),
        ]);
    }

    public function process(Request $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('catalog')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'delivery_notes' => 'nullable|string|max:500',
        ]);

        // Find or create customer
        $customer = Customer::firstOrCreate(
            ['email' => $validated['email']],
            [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip' => $validated['zip'],
            ]
        );

        $deliveryAddress = [
            'line_1' => $validated['address_line_1'],
            'line_2' => $validated['address_line_2'] ?? null,
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip' => $validated['zip'],
        ];

        $order = $this->orderService->createFromCart(
            $this->cart->items(),
            $customer,
            $deliveryAddress,
            $validated['delivery_notes'] ?? null
        );

        // Simulate payment (demo mode — no real Stripe)
        $demoPaymentId = 'pi_demo_' . uniqid();
        $this->orderService->recordPayment($order, $demoPaymentId);

        $this->cart->clear();

        return redirect()->route('checkout.confirmation', $order)
            ->with('success', 'Order placed successfully!');
    }

    public function confirmation(Order $order)
    {
        $order->load(['items.piano.brand', 'customer', 'payments']);
        return view('storefront.checkout-confirmation', compact('order'));
    }
}
