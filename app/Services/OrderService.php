<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\LedgerEntry;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Piano;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private StatusTransitionService $statusService
    ) {}

    public function createFromCart(array $cartItems, Customer $customer, array $deliveryAddress = [], ?string $deliveryNotes = null): Order
    {
        return DB::transaction(function () use ($cartItems, $customer, $deliveryAddress, $deliveryNotes) {
            $subtotal = collect($cartItems)->sum('price');
            $taxRate = config('pianohaus.tax_rate');
            $taxAmount = (int) round($subtotal * $taxRate);
            $deliveryFee = !empty($cartItems) ? config('pianohaus.delivery.base_fee') : 0;
            $total = $subtotal + $taxAmount + $deliveryFee;

            $order = Order::create([
                'customer_id' => $customer->id,
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'tax_rate' => $taxRate,
                'delivery_address' => $deliveryAddress ?: null,
                'delivery_notes' => $deliveryNotes,
            ]);

            foreach ($cartItems as $item) {
                $piano = Piano::find($item['piano_id']);
                $order->items()->create([
                    'piano_id' => $piano->id,
                    'price' => $item['price'],
                    'quantity' => 1,
                ]);
                $piano->update(['status' => 'reserved']);
            }

            return $order;
        });
    }

    public function recordPayment(Order $order, string $stripePaymentId): Payment
    {
        return DB::transaction(function () use ($order, $stripePaymentId) {
            $payment = Payment::create([
                'customer_id' => $order->customer_id,
                'order_id' => $order->id,
                'amount' => $order->total,
                'type' => 'purchase',
                'status' => 'completed',
                'method' => 'stripe_card',
                'stripe_payment_id' => $stripePaymentId,
                'paid_at' => now(),
            ]);

            $order->update([
                'status' => 'confirmed',
                'paid_at' => now(),
                'stripe_payment_intent_id' => $stripePaymentId,
            ]);

            // Mark pianos as sold
            foreach ($order->items as $item) {
                $item->piano->markAsSold();
            }

            // Ledger entry
            $lastBalance = LedgerEntry::where('customer_id', $order->customer_id)
                ->latest('id')->value('running_balance') ?? 0;

            LedgerEntry::create([
                'payment_id' => $payment->id,
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'type' => 'payment',
                'amount' => -$order->total,
                'running_balance' => $lastBalance - $order->total,
                'description' => "Payment for order {$order->order_number}",
                'reference' => $stripePaymentId,
                'created_at' => now(),
            ]);

            return $payment;
        });
    }

    public function updateStatus(Order $order, string $newStatus): void
    {
        $this->statusService->transition($order, $newStatus);
    }
}
