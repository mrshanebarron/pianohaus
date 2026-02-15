<x-layouts.storefront :title="'My Documents'">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-2xl font-bold text-ebony-800">My Documents</h1>
                <p class="text-sm font-ui text-ivory-600 mt-1">Contracts, invoices, and agreements</p>
            </div>
            <a href="{{ route('portal.dashboard') }}" class="text-sm font-ui text-gold-600 hover:text-gold-500 transition">&larr; Back to Dashboard</a>
        </div>

        @include('portal._nav')

        {{-- Contracts --}}
        <div class="mb-8">
            <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Contracts</h2>
            @if($contracts->count())
                <div class="space-y-3">
                    @foreach($contracts as $contract)
                        <div class="bg-white rounded-xl border border-ivory-400/50 p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-ebony-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-ebony-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-ui font-medium text-ebony-800">{{ $contract->contract_number }}</p>
                                    <p class="text-xs font-ui text-ivory-600">
                                        {{ $contract->rental?->piano?->name ?? 'Rental Agreement' }}
                                        &middot; {{ $contract->created_at->format('M j, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-ui font-medium bg-{{ $contract->status_color }}-100 text-{{ $contract->status_color }}-700">{{ $contract->status_label }}</span>
                                @if(!$contract->customer_signed_at && !in_array($contract->status, ['voided', 'expired']))
                                    <a href="{{ route('contract.sign', $contract) }}" class="bg-gold-500 hover:bg-gold-400 text-ebony-900 text-xs font-ui font-semibold px-4 py-2 rounded-lg transition">Sign</a>
                                @endif
                                @if($contract->pdf_path)
                                    <a href="{{ route('admin.contracts.pdf', $contract) }}" class="text-sm font-ui text-gold-600 hover:text-gold-500 transition flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                        PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl border border-ivory-400/50 p-8 text-center">
                    <p class="text-sm font-ui text-ivory-600">No contracts on file.</p>
                </div>
            @endif
        </div>

        {{-- Invoices --}}
        <div>
            <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Invoices</h2>
            @if($invoices->count())
                <div class="bg-white rounded-xl border border-ivory-400/50 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm font-ui">
                            <thead>
                                <tr class="bg-ivory-50 border-b border-ivory-300">
                                    <th class="text-left px-5 py-3 text-ivory-600 font-medium">Invoice</th>
                                    <th class="text-left px-5 py-3 text-ivory-600 font-medium">Date</th>
                                    <th class="text-left px-5 py-3 text-ivory-600 font-medium">For</th>
                                    <th class="text-left px-5 py-3 text-ivory-600 font-medium">Due</th>
                                    <th class="text-center px-5 py-3 text-ivory-600 font-medium">Status</th>
                                    <th class="text-right px-5 py-3 text-ivory-600 font-medium">Total</th>
                                    <th class="text-right px-5 py-3 text-ivory-600 font-medium"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                    <tr class="border-b border-ivory-200/50 hover:bg-ivory-50 transition">
                                        <td class="px-5 py-3.5 font-medium text-ebony-800">{{ $invoice->invoice_number }}</td>
                                        <td class="px-5 py-3.5 text-ivory-700">{{ $invoice->created_at->format('M j, Y') }}</td>
                                        <td class="px-5 py-3.5 text-ivory-700">
                                            @if($invoice->order)
                                                {{ $invoice->order->order_number }}
                                            @elseif($invoice->rental)
                                                {{ $invoice->rental->rental_number }}
                                            @else
                                                &mdash;
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 {{ $invoice->is_overdue ? 'text-red-600 font-semibold' : 'text-ivory-700' }}">{{ $invoice->due_date->format('M j, Y') }}</td>
                                        <td class="px-5 py-3.5 text-center">
                                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-{{ $invoice->status_color }}-100 text-{{ $invoice->status_color }}-700">{{ $invoice->status_label }}</span>
                                        </td>
                                        <td class="px-5 py-3.5 text-right font-semibold text-ebony-800">{{ $invoice->formatted_total }}</td>
                                        <td class="px-5 py-3.5 text-right">
                                            @if($invoice->pdf_path)
                                                <a href="{{ route('admin.invoices.pdf', $invoice) }}" class="text-gold-600 hover:text-gold-500 transition">
                                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl border border-ivory-400/50 p-8 text-center">
                    <p class="text-sm font-ui text-ivory-600">No invoices on file.</p>
                </div>
            @endif
        </div>
    </div>

</x-layouts.storefront>
