<x-layouts.storefront :title="'Payment History'">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-2xl font-bold text-ebony-800">Payment History</h1>
                <p class="text-sm font-ui text-ivory-600 mt-1">All transactions and payment records</p>
            </div>
            <a href="{{ route('portal.dashboard') }}" class="text-sm font-ui text-gold-600 hover:text-gold-500 transition">&larr; Back to Dashboard</a>
        </div>

        @include('portal._nav')

        @if($payments instanceof \Illuminate\Pagination\LengthAwarePaginator && $payments->count())
            <div class="bg-white rounded-xl border border-ivory-400/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm font-ui">
                        <thead>
                            <tr class="bg-ivory-50 border-b border-ivory-300">
                                <th class="text-left px-5 py-3 text-ivory-600 font-medium">Date</th>
                                <th class="text-left px-5 py-3 text-ivory-600 font-medium">Type</th>
                                <th class="text-left px-5 py-3 text-ivory-600 font-medium">Reference</th>
                                <th class="text-left px-5 py-3 text-ivory-600 font-medium">Method</th>
                                <th class="text-center px-5 py-3 text-ivory-600 font-medium">Status</th>
                                <th class="text-right px-5 py-3 text-ivory-600 font-medium">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr class="border-b border-ivory-200/50 hover:bg-ivory-50 transition">
                                    <td class="px-5 py-3.5 text-ivory-700">{{ $payment->paid_at?->format('M j, Y') ?? $payment->created_at->format('M j, Y') }}</td>
                                    <td class="px-5 py-3.5">
                                        <span class="font-medium text-ebony-800">{{ $payment->type_label }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-ivory-700">
                                        @if($payment->order)
                                            <a href="{{ route('portal.orders.show', $payment->order) }}" class="text-gold-600 hover:text-gold-500">{{ $payment->order->order_number }}</a>
                                        @elseif($payment->rental)
                                            <a href="{{ route('portal.rentals.show', $payment->rental) }}" class="text-gold-600 hover:text-gold-500">{{ $payment->rental->rental_number }}</a>
                                        @else
                                            <span class="text-ivory-500">&mdash;</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-ivory-700">{{ ucfirst($payment->method ?? 'Card') }}</td>
                                    <td class="px-5 py-3.5 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-{{ $payment->status_color }}-100 text-{{ $payment->status_color }}-700">{{ $payment->status_label }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right font-semibold text-ebony-800">{{ $payment->formatted_amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $payments->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl border border-ivory-400/50 p-12 text-center">
                <svg class="w-12 h-12 text-ivory-400 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                <h3 class="font-display text-lg font-semibold text-ebony-800 mb-2">No Payments Yet</h3>
                <p class="text-sm font-ui text-ivory-600">Your payment history will appear here after your first purchase or rental payment.</p>
            </div>
        @endif
    </div>

</x-layouts.storefront>
