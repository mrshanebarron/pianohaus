<x-layouts.admin title="Invoice {{ $invoice->invoice_number }}">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.invoices.index') }}" class="text-ebony-400 hover:text-ivory-300 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </a>
        <div class="flex-1">
            <h2 class="text-xl font-display font-semibold text-ivory-100">{{ $invoice->invoice_number }}</h2>
            <p class="text-sm text-ebony-400">{{ $invoice->customer->full_name ?? 'N/A' }} &middot; Due {{ $invoice->due_date->format('M j, Y') }}</p>
        </div>
        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $invoice->status_color }}-500/20 text-{{ $invoice->status_color }}-400">{{ $invoice->status_label }}</span>
    </div>

    <div class="max-w-2xl bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
        <table class="w-full text-sm mb-4">
            <thead>
                <tr class="border-b border-ebony-600/30">
                    <th class="text-left py-2 text-xs font-semibold uppercase text-ebony-400">Description</th>
                    <th class="text-right py-2 text-xs font-semibold uppercase text-ebony-400">Qty</th>
                    <th class="text-right py-2 text-xs font-semibold uppercase text-ebony-400">Price</th>
                    <th class="text-right py-2 text-xs font-semibold uppercase text-ebony-400">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebony-600/20">
                @foreach($invoice->items as $item)
                    <tr>
                        <td class="py-2 text-ivory-300">{{ $item->description }}</td>
                        <td class="py-2 text-right text-ivory-300">{{ $item->quantity }}</td>
                        <td class="py-2 text-right text-ivory-300">${{ number_format($item->unit_price / 100, 2) }}</td>
                        <td class="py-2 text-right text-ivory-100 font-medium">${{ number_format($item->total / 100, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="border-t border-ebony-600/30 pt-3 space-y-2">
            <div class="flex justify-between text-sm"><span class="text-ebony-400">Total</span><span class="font-semibold text-ivory-100">{{ $invoice->formatted_total }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-ebony-400">Paid</span><span class="text-green-400">${{ number_format($invoice->paid_amount / 100, 2) }}</span></div>
            <div class="flex justify-between text-sm font-semibold"><span class="text-ivory-100">Balance Due</span><span class="{{ $invoice->balance_due > 0 ? 'text-yellow-400' : 'text-green-400' }}">{{ $invoice->formatted_balance_due }}</span></div>
        </div>
    </div>
</x-layouts.admin>
