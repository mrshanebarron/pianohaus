<x-layouts.admin title="Dashboard">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-ebony-400">Total Pianos</span>
                <span class="w-8 h-8 bg-gold-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-ivory-100">{{ $stats['total_pianos'] }}</div>
            <div class="text-xs text-ebony-400 mt-1">{{ $stats['available_pianos'] }} available</div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-ebony-400">Active Rentals</span>
                <span class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-ivory-100">{{ $stats['active_rentals'] }}</div>
            <div class="text-xs text-ebony-400 mt-1">{{ $stats['pending_applications'] }} pending applications</div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-ebony-400">Monthly Revenue</span>
                <span class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-ivory-100">${{ number_format($stats['monthly_revenue'] / 100, 0) }}</div>
            <div class="text-xs text-ebony-400 mt-1">${{ number_format($stats['total_revenue'] / 100, 0) }} total</div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-ebony-400">Pending</span>
                <span class="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-ivory-100">{{ $stats['pending_orders'] + $stats['pending_reviews'] }}</div>
            <div class="text-xs text-ebony-400 mt-1">{{ $stats['pending_orders'] }} orders, {{ $stats['pending_reviews'] }} reviews</div>
        </div>
    </div>

    {{-- Revenue Chart --}}
    <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6 mb-8">
        <h2 class="text-lg font-display font-semibold text-ivory-100 mb-4">Revenue (6 Months)</h2>
        <div class="flex items-end gap-2 h-48" x-data="{
            data: {{ json_encode(array_column($monthlyRevenue, 'revenue')) }},
            labels: {{ json_encode(array_column($monthlyRevenue, 'month')) }},
            max: Math.max({{ max(array_column($monthlyRevenue, 'revenue')) ?: 1 }}, 1)
        }">
            <template x-for="(value, index) in data" :key="index">
                <div class="flex-1 flex flex-col items-center gap-2">
                    <span class="text-xs text-ivory-300 font-medium" x-text="value > 0 ? '$' + Math.round(value).toLocaleString() : '$0'"></span>
                    <div class="w-full bg-gold-500/80 rounded-t-md transition-all duration-500"
                         :style="'height: ' + (value > 0 ? Math.max((value / max) * 140, 4) : 4) + 'px'"></div>
                    <span class="text-xs text-ebony-400" x-text="labels[index]"></span>
                </div>
            </template>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Orders --}}
        <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-display font-semibold text-ivory-100">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-xs text-gold-400 hover:text-gold-300">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($recentOrders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-3 rounded-lg bg-ebony-800/50 hover:bg-ebony-700/50 transition group">
                        <div>
                            <div class="text-sm font-medium text-ivory-100 group-hover:text-gold-400 transition">{{ $order->order_number }}</div>
                            <div class="text-xs text-ebony-400">{{ $order->customer->full_name ?? 'N/A' }} &middot; {{ $order->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-semibold text-ivory-100">{{ $order->formatted_total }}</div>
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $order->status_color }}-500/20 text-{{ $order->status_color }}-400">
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-ebony-400 text-center py-4">No orders yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Pending Rental Applications --}}
        <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-display font-semibold text-ivory-100">Rental Applications</h2>
                <a href="{{ route('admin.rentals.index') }}" class="text-xs text-gold-400 hover:text-gold-300">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($pendingRentals as $rental)
                    <a href="{{ route('admin.rentals.show', $rental) }}" class="flex items-center justify-between p-3 rounded-lg bg-ebony-800/50 hover:bg-ebony-700/50 transition group">
                        <div>
                            <div class="text-sm font-medium text-ivory-100 group-hover:text-gold-400 transition">{{ $rental->customer->full_name ?? 'N/A' }}</div>
                            <div class="text-xs text-ebony-400">{{ $rental->piano->name ?? 'N/A' }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-semibold text-ivory-100">{{ $rental->formatted_monthly_rate }}/mo</div>
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400">
                                Pending
                            </span>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-ebony-400 text-center py-4">No pending applications.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Payments --}}
        <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-display font-semibold text-ivory-100">Recent Payments</h2>
            </div>
            <div class="space-y-3">
                @forelse($recentPayments as $payment)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-ebony-800/50">
                        <div>
                            <div class="text-sm font-medium text-ivory-100">{{ $payment->customer->full_name ?? 'N/A' }}</div>
                            <div class="text-xs text-ebony-400">{{ ucfirst(str_replace('_', ' ', $payment->type)) }} &middot; {{ $payment->paid_at->diffForHumans() }}</div>
                        </div>
                        <div class="text-sm font-semibold text-green-400">+${{ number_format($payment->amount / 100, 2) }}</div>
                    </div>
                @empty
                    <p class="text-sm text-ebony-400 text-center py-4">No payments yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Inventory Breakdown --}}
        <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
            <h2 class="text-lg font-display font-semibold text-ivory-100 mb-4">Inventory Status</h2>
            <div class="space-y-3">
                @foreach([
                    'available' => ['label' => 'Available', 'color' => 'green'],
                    'reserved' => ['label' => 'Reserved', 'color' => 'blue'],
                    'sold' => ['label' => 'Sold', 'color' => 'gray'],
                    'rented' => ['label' => 'Rented', 'color' => 'indigo'],
                    'maintenance' => ['label' => 'Maintenance', 'color' => 'yellow'],
                ] as $status => $meta)
                    @php $count = $inventoryBreakdown[$status] ?? 0; $total = max(array_sum($inventoryBreakdown), 1); @endphp
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-2.5 h-2.5 rounded-full bg-{{ $meta['color'] }}-400"></div>
                            <span class="text-sm text-ivory-300">{{ $meta['label'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-24 h-1.5 bg-ebony-600/50 rounded-full overflow-hidden">
                                <div class="h-full bg-{{ $meta['color'] }}-400 rounded-full" style="width: {{ ($count / $total) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-ivory-100 w-6 text-right">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</x-layouts.admin>
