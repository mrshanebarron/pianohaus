<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Rental;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    public function createForOrder(Order $order): Invoice
    {
        $invoice = Invoice::create([
            'customer_id' => $order->customer_id,
            'order_id' => $order->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'status' => $order->is_paid ? 'paid' : 'sent',
            'subtotal' => $order->subtotal,
            'tax_amount' => $order->tax_amount,
            'total' => $order->total,
            'paid_amount' => $order->is_paid ? $order->total : 0,
            'due_date' => now()->addDays(30),
            'paid_at' => $order->paid_at,
            'sent_at' => now(),
        ]);

        foreach ($order->items as $item) {
            $invoice->items()->create([
                'description' => $item->piano->name . ' (' . $item->piano->brand->name . ')',
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'total' => $item->price * $item->quantity,
            ]);
        }

        if ($order->delivery_fee > 0) {
            $invoice->items()->create([
                'description' => 'Delivery & Setup',
                'quantity' => 1,
                'unit_price' => $order->delivery_fee,
                'total' => $order->delivery_fee,
            ]);
        }

        $this->generatePdf($invoice);

        return $invoice;
    }

    public function createForRentalDeposit(Rental $rental): Invoice
    {
        $invoice = Invoice::create([
            'customer_id' => $rental->customer_id,
            'rental_id' => $rental->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'status' => 'sent',
            'subtotal' => $rental->deposit_amount + $rental->monthly_rate,
            'tax_amount' => 0,
            'total' => $rental->deposit_amount + $rental->monthly_rate,
            'paid_amount' => 0,
            'due_date' => now()->addDays(7),
            'sent_at' => now(),
        ]);

        $invoice->items()->create([
            'description' => 'Security Deposit — ' . $rental->piano->name,
            'quantity' => 1,
            'unit_price' => $rental->deposit_amount,
            'total' => $rental->deposit_amount,
        ]);

        $invoice->items()->create([
            'description' => 'First Month Rental — ' . $rental->piano->name,
            'quantity' => 1,
            'unit_price' => $rental->monthly_rate,
            'total' => $rental->monthly_rate,
        ]);

        $this->generatePdf($invoice);

        return $invoice;
    }

    public function generatePdf(Invoice $invoice): string
    {
        $invoice->load(['customer', 'items', 'order', 'rental']);

        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'company' => config('pianohaus.company'),
        ]);

        $path = "invoices/{$invoice->invoice_number}.pdf";
        Storage::disk('local')->put($path, $pdf->output());

        $invoice->update(['pdf_path' => $path]);

        return $path;
    }

    public function markPaid(Invoice $invoice): void
    {
        $invoice->update([
            'status' => 'paid',
            'paid_amount' => $invoice->total,
            'paid_at' => now(),
        ]);
    }
}
