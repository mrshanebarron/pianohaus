<x-layouts.admin title="Orders">
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-ebony-400">{{ $orders->total() }} orders</p>
        <form method="GET" class="flex gap-3">
            <select name="status" onchange="this.form.submit()" class="bg-ebony-700/40 border border-ebony-600/30 rounded-lg px-3 py-2 text-sm text-ivory-300 focus:border-gold-500 focus:outline-none">
                <option value="">All Statuses</option>
                @foreach(['pending', 'confirmed', 'processing', 'delivered', 'completed', 'cancelled', 'refunded'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-ebony-600/30">
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Order</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Customer</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Items</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Total</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Status</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebony-600/20">
                @forelse($orders as $order)
                    <tr class="hover:bg-ebony-700/30 transition cursor-pointer" onclick="window.location='{{ route('admin.orders.show', $order) }}'">
                        <td class="px-4 py-3 font-medium text-ivory-100">{{ $order->order_number }}</td>
                        <td class="px-4 py-3 text-ivory-300">{{ $order->customer->full_name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-ebony-300">{{ $order->items->count() }} item(s)</td>
                        <td class="px-4 py-3 text-right font-semibold text-ivory-100">{{ $order->formatted_total }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $order->status_color }}-500/20 text-{{ $order->status_color }}-400">{{ $order->status_label }}</span>
                        </td>
                        <td class="px-4 py-3 text-right text-ebony-400 text-xs">{{ $order->created_at->format('M j, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-ebony-400">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $orders->withQueryString()->links() }}</div>
</x-layouts.admin>
