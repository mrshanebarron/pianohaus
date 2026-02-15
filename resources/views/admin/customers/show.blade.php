<x-layouts.admin title="{{ $customer->full_name }}">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.customers.index') }}" class="text-ebony-400 hover:text-ivory-300 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </a>
        <div>
            <h2 class="text-xl font-display font-semibold text-ivory-100">{{ $customer->full_name }}</h2>
            <p class="text-sm text-ebony-400">{{ $customer->email }} &middot; {{ $customer->phone }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="stat-card">
            <div class="text-xs font-semibold uppercase tracking-wider text-ebony-400 mb-2">Total Spent</div>
            <div class="text-2xl font-bold text-ivory-100">{{ $customer->formatted_total_spent }}</div>
        </div>
        <div class="stat-card">
            <div class="text-xs font-semibold uppercase tracking-wider text-ebony-400 mb-2">Orders</div>
            <div class="text-2xl font-bold text-ivory-100">{{ $customer->orders->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="text-xs font-semibold uppercase tracking-wider text-ebony-400 mb-2">Rentals</div>
            <div class="text-2xl font-bold text-ivory-100">{{ $customer->rentals->count() }}</div>
        </div>
    </div>

    <div x-data="{ tab: 'orders' }" class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl overflow-hidden">
        <div class="flex border-b border-ebony-600/30">
            @foreach(['orders' => 'Orders', 'rentals' => 'Rentals', 'payments' => 'Payments'] as $key => $label)
                <button @click="tab = '{{ $key }}'" :class="tab === '{{ $key }}' ? 'text-gold-400 border-gold-500' : 'text-ebony-400 border-transparent hover:text-ivory-300'"
                        class="px-6 py-3 text-sm font-medium border-b-2 transition">{{ $label }}</button>
            @endforeach
        </div>
        <div class="p-6">
            {{-- Orders tab --}}
            <div x-show="tab === 'orders'" x-cloak>
                <div class="space-y-2">
                    @forelse($customer->orders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-3 bg-ebony-800/50 rounded-lg hover:bg-ebony-700/50 transition">
                            <div>
                                <div class="text-sm font-medium text-ivory-100">{{ $order->order_number }}</div>
                                <div class="text-xs text-ebony-400">{{ $order->created_at->format('M j, Y') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold text-ivory-100">{{ $order->formatted_total }}</div>
                                <span class="px-2 py-0.5 rounded-full text-xs bg-{{ $order->status_color }}-500/20 text-{{ $order->status_color }}-400">{{ $order->status_label }}</span>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-ebony-400 text-center py-4">No orders.</p>
                    @endforelse
                </div>
            </div>

            {{-- Rentals tab --}}
            <div x-show="tab === 'rentals'" x-cloak>
                <div class="space-y-2">
                    @forelse($customer->rentals as $rental)
                        <a href="{{ route('admin.rentals.show', $rental) }}" class="flex items-center justify-between p-3 bg-ebony-800/50 rounded-lg hover:bg-ebony-700/50 transition">
                            <div>
                                <div class="text-sm font-medium text-ivory-100">{{ $rental->rental_number }}</div>
                                <div class="text-xs text-ebony-400">{{ $rental->piano->name ?? 'N/A' }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold text-ivory-100">{{ $rental->formatted_monthly_rate }}/mo</div>
                                <span class="px-2 py-0.5 rounded-full text-xs bg-{{ $rental->status_color }}-500/20 text-{{ $rental->status_color }}-400">{{ $rental->status_label }}</span>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-ebony-400 text-center py-4">No rentals.</p>
                    @endforelse
                </div>
            </div>

            {{-- Payments tab --}}
            <div x-show="tab === 'payments'" x-cloak>
                <div class="space-y-2">
                    @forelse($customer->payments as $payment)
                        <div class="flex items-center justify-between p-3 bg-ebony-800/50 rounded-lg">
                            <div>
                                <div class="text-sm text-ivory-100">{{ ucfirst(str_replace('_', ' ', $payment->type)) }}</div>
                                <div class="text-xs text-ebony-400">{{ $payment->paid_at?->format('M j, Y') }}</div>
                            </div>
                            <div class="text-sm font-semibold {{ $payment->type === 'refund' ? 'text-red-400' : 'text-green-400' }}">
                                ${{ number_format($payment->amount / 100, 2) }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-ebony-400 text-center py-4">No payments.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
