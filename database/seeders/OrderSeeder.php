<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\LedgerEntry;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Piano;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $salePianos = Piano::whereIn('type', ['sale', 'both'])->where('status', 'available')->get();

        $taxRate = config('pianohaus.tax_rate', 8.25);
        $runningBalance = 0;

        $orders = [
            // Completed order — Steinway Model M
            [
                'customer_index' => 0, 'piano_index' => 3,
                'status' => 'completed', 'days_ago' => 45,
                'delivery_fee' => 15000,
            ],
            // Completed order — Yamaha CLP-785
            [
                'customer_index' => 1, 'piano_index' => 12,
                'status' => 'completed', 'days_ago' => 30,
                'delivery_fee' => 0,
            ],
            // Delivered, awaiting completion — Roland LX-708
            [
                'customer_index' => 2, 'piano_index' => 11,
                'status' => 'delivered', 'days_ago' => 7,
                'delivery_fee' => 15000,
            ],
            // Processing — Bösendorfer 170
            [
                'customer_index' => 4, 'piano_index' => 5,
                'status' => 'processing', 'days_ago' => 3,
                'delivery_fee' => 25000,
            ],
            // Pending — Baldwin M1
            [
                'customer_index' => 6, 'piano_index' => 19,
                'status' => 'pending', 'days_ago' => 1,
                'delivery_fee' => 15000,
            ],
        ];

        foreach ($orders as $orderData) {
            $customer = $customers[$orderData['customer_index']];
            $piano = $salePianos[$orderData['piano_index']] ?? $salePianos->random();

            $subtotal = $piano->sale_price;
            $taxAmount = (int) round($subtotal * $taxRate / 100);
            $deliveryFee = $orderData['delivery_fee'];
            $total = $subtotal + $taxAmount + $deliveryFee;
            $paidAt = in_array($orderData['status'], ['completed', 'delivered', 'processing'])
                ? now()->subDays($orderData['days_ago'])
                : null;

            $order = Order::create([
                'customer_id' => $customer->id,
                'order_number' => Order::generateOrderNumber(),
                'status' => $orderData['status'],
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'tax_rate' => $taxRate,
                'delivery_fee' => $deliveryFee,
                'discount_amount' => 0,
                'total' => $total,
                'delivery_address' => [
                    'line_1' => $customer->address_line_1,
                    'city' => $customer->city,
                    'state' => $customer->state,
                    'zip' => $customer->zip,
                ],
                'paid_at' => $paidAt,
                'created_at' => now()->subDays($orderData['days_ago']),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'piano_id' => $piano->id,
                'price' => $piano->sale_price,
                'quantity' => 1,
            ]);

            // Mark piano as sold for completed/delivered orders
            if (in_array($orderData['status'], ['completed', 'delivered'])) {
                $piano->update(['status' => 'sold']);
            } elseif ($orderData['status'] === 'processing') {
                $piano->update(['status' => 'reserved']);
            }

            // Create payment for paid orders
            if ($paidAt) {
                $payment = Payment::create([
                    'customer_id' => $customer->id,
                    'order_id' => $order->id,
                    'amount' => $total,
                    'type' => 'purchase',
                    'status' => 'completed',
                    'method' => 'stripe',
                    'stripe_payment_id' => 'pi_demo_' . strtolower(str_replace('-', '', substr(fake()->uuid(), 0, 13))),
                    'paid_at' => $paidAt,
                ]);

                $runningBalance += $total;

                LedgerEntry::create([
                    'payment_id' => $payment->id,
                    'order_id' => $order->id,
                    'customer_id' => $customer->id,
                    'type' => 'sale',
                    'amount' => $total,
                    'running_balance' => $runningBalance,
                    'description' => "Payment for order {$order->order_number}",
                    'reference' => $payment->stripe_payment_id,
                    'created_at' => $paidAt,
                ]);

                // Create invoice
                $invoice = Invoice::create([
                    'customer_id' => $customer->id,
                    'order_id' => $order->id,
                    'invoice_number' => Invoice::generateInvoiceNumber(),
                    'status' => 'paid',
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'total' => $total,
                    'paid_amount' => $total,
                    'due_date' => $paidAt->copy()->addDays(30),
                ]);

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $piano->name,
                    'quantity' => 1,
                    'unit_price' => $piano->sale_price,
                    'total' => $piano->sale_price,
                ]);

                if ($deliveryFee > 0) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'description' => 'White Glove Delivery',
                        'quantity' => 1,
                        'unit_price' => $deliveryFee,
                        'total' => $deliveryFee,
                    ]);
                }

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => "Sales Tax ({$taxRate}%)",
                    'quantity' => 1,
                    'unit_price' => $taxAmount,
                    'total' => $taxAmount,
                ]);
            }
        }
    }
}
