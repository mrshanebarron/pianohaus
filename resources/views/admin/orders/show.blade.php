<x-layouts.admin title="Order {{ $order->order_number }}">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-ebony-400 hover:text-ivory-300 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-display font-semibold text-ivory-100">{{ $order->order_number }}</h2>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $order->status_color }}-500/20 text-{{ $order->status_color }}-400">{{ $order->status_label }}</span>
            </div>
            <p class="text-sm text-ebony-400">Placed {{ $order->created_at->format('M j, Y g:ia') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Items --}}
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Order Items</h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between p-3 bg-ebony-800/50 rounded-lg">
                            <div>
                                <div class="text-sm font-medium text-ivory-100">{{ $item->piano->name ?? 'Deleted Piano' }}</div>
                                <div class="text-xs text-ebony-400">Qty: {{ $item->quantity }}</div>
                            </div>
                            <div class="text-sm font-semibold text-ivory-100">{{ $item->formatted_price }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-ebony-600/30 space-y-2">
                    <div class="flex justify-between text-sm"><span class="text-ebony-400">Subtotal</span><span class="text-ivory-300">{{ $order->formatted_subtotal }}</span></div>
                    <div class="flex justify-between text-sm"><span class="text-ebony-400">Tax ({{ $order->tax_rate }}%)</span><span class="text-ivory-300">{{ $order->formatted_tax }}</span></div>
                    <div class="flex justify-between text-sm"><span class="text-ebony-400">Delivery</span><span class="text-ivory-300">{{ $order->formatted_delivery_fee }}</span></div>
                    <div class="flex justify-between text-sm font-semibold pt-2 border-t border-ebony-600/30"><span class="text-ivory-100">Total</span><span class="text-ivory-100">{{ $order->formatted_total }}</span></div>
                </div>
            </div>

            {{-- Status Transitions --}}
            @if(count($allowedTransitions) > 0)
                <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Update Status</h3>
                    <div class="flex gap-2 flex-wrap">
                        @foreach($allowedTransitions as $transition)
                            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="{{ $transition }}">
                                <button type="submit" class="px-4 py-2 bg-ebony-600/50 text-ivory-300 rounded-lg text-sm hover:bg-ebony-600 transition">
                                    Mark as {{ ucfirst(str_replace('_', ' ', $transition)) }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Payments --}}
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Payments</h3>
                @forelse($order->payments as $payment)
                    <div class="flex items-center justify-between p-3 bg-ebony-800/50 rounded-lg mb-2">
                        <div>
                            <div class="text-sm text-ivory-100">{{ ucfirst(str_replace('_', ' ', $payment->type)) }}</div>
                            <div class="text-xs text-ebony-400">{{ $payment->paid_at?->format('M j, Y') }} &middot; {{ $payment->stripe_payment_id }}</div>
                        </div>
                        <div class="text-sm font-semibold text-green-400">${{ number_format($payment->amount / 100, 2) }}</div>
                    </div>
                @empty
                    <p class="text-sm text-ebony-400 text-center py-4">No payments recorded.</p>
                @endforelse
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="space-y-6">
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Customer</h3>
                @if($order->customer)
                    <div class="space-y-2">
                        <div class="text-sm font-medium text-ivory-100">{{ $order->customer->full_name }}</div>
                        <div class="text-sm text-ebony-400">{{ $order->customer->email }}</div>
                        <div class="text-sm text-ebony-400">{{ $order->customer->phone }}</div>
                    </div>
                    <a href="{{ route('admin.customers.show', $order->customer) }}" class="inline-block mt-3 text-xs text-gold-400 hover:text-gold-300">View Customer</a>
                @endif
            </div>

            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Delivery Address</h3>
                @if($order->delivery_address)
                    <div class="text-sm text-ivory-300 space-y-1">
                        <div>{{ $order->delivery_address['line_1'] ?? '' }}</div>
                        <div>{{ $order->delivery_address['city'] ?? '' }}, {{ $order->delivery_address['state'] ?? '' }} {{ $order->delivery_address['zip'] ?? '' }}</div>
                    </div>
                @else
                    <p class="text-sm text-ebony-400">No address provided.</p>
                @endif
            </div>

            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Timeline</h3>
                <div class="space-y-3">
                    @if($order->paid_at)
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-400 mt-1.5"></div>
                            <div><div class="text-sm text-ivory-300">Payment received</div><div class="text-xs text-ebony-400">{{ $order->paid_at->format('M j, Y g:ia') }}</div></div>
                        </div>
                    @endif
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-ebony-400 mt-1.5"></div>
                        <div><div class="text-sm text-ivory-300">Order placed</div><div class="text-xs text-ebony-400">{{ $order->created_at->format('M j, Y g:ia') }}</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
