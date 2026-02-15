<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('customer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest()->paginate(15);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('customer', 'items', 'order', 'rental');
        return view('admin.invoices.show', compact('invoice'));
    }

    public function downloadPdf(Invoice $invoice, InvoiceService $invoiceService)
    {
        if (!$invoice->pdf_path || !Storage::disk('local')->exists($invoice->pdf_path)) {
            $invoiceService->generatePdf($invoice);
        }

        return Storage::disk('local')->download($invoice->pdf_path, $invoice->invoice_number . '.pdf');
    }
}
