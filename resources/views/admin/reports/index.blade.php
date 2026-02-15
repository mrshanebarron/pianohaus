<x-layouts.admin title="Reports">

    {{-- Revenue Summary --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="stat-card">
            <div class="text-xs font-semibold uppercase tracking-wider text-ebony-400 mb-2">Total Revenue</div>
            <div class="text-2xl font-bold text-ivory-100">${{ number_format($totalRevenue / 100, 0) }}</div>
        </div>
        <div class="stat-card">
            <div class="text-xs font-semibold uppercase tracking-wider text-ebony-400 mb-2">Sales Revenue</div>
            <div class="text-2xl font-bold text-ivory-100">${{ number_format($salesRevenue / 100, 0) }}</div>
        </div>
        <div class="stat-card">
            <div class="text-xs font-semibold uppercase tracking-wider text-ebony-400 mb-2">Rental Revenue</div>
            <div class="text-2xl font-bold text-ivory-100">${{ number_format($rentalRevenue / 100, 0) }}</div>
        </div>
    </div>

    {{-- Revenue Chart --}}
    <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6 mb-8">
        <h2 class="text-lg font-display font-semibold text-ivory-100 mb-4">Revenue (12 Months)</h2>
        <div class="flex items-end gap-1 h-52" x-data="{
            data: {{ json_encode(array_column($monthlyRevenue, 'revenue')) }},
            labels: {{ json_encode(array_column($monthlyRevenue, 'month')) }},
            max: Math.max({{ max(array_column($monthlyRevenue, 'revenue')) ?: 1 }}, 1)
        }">
            <template x-for="(value, index) in data" :key="index">
                <div class="flex-1 flex flex-col items-center gap-1">
                    <span class="text-xs text-ivory-300 font-medium" x-show="value > 0" x-text="'$' + Math.round(value).toLocaleString()"></span>
                    <div class="w-full bg-gold-500/80 rounded-t transition-all duration-500"
                         :style="'height: ' + (value > 0 ? Math.max((value / max) * 160, 4) : 4) + 'px'"></div>
                    <span class="text-xs text-ebony-400 whitespace-nowrap" x-text="labels[index]"></span>
                </div>
            </template>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Inventory by Category --}}
        <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
            <h2 class="text-lg font-display font-semibold text-ivory-100 mb-4">Available Inventory by Category</h2>
            <div class="space-y-4">
                @foreach($inventoryByCategory as $cat)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-ivory-300">{{ $cat->name }}</span>
                            <span class="text-ebony-400">{{ $cat->count }} pianos &middot; ${{ number_format(($cat->total_value ?? 0) / 100, 0) }}</span>
                        </div>
                        <div class="w-full h-2 bg-ebony-600/50 rounded-full overflow-hidden">
                            <div class="h-full bg-gold-500 rounded-full" style="width: {{ $inventoryValue > 0 ? (($cat->total_value ?? 0) / $inventoryValue) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t border-ebony-600/30">
                <div class="flex justify-between text-sm font-semibold">
                    <span class="text-ivory-100">Total Inventory Value</span>
                    <span class="text-ivory-100">${{ number_format($inventoryValue / 100, 0) }}</span>
                </div>
            </div>
        </div>

        {{-- Inventory by Brand --}}
        <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
            <h2 class="text-lg font-display font-semibold text-ivory-100 mb-4">Inventory by Brand</h2>
            <div class="space-y-3">
                @php $totalPianos = max($inventoryByBrand->sum('count'), 1); @endphp
                @foreach($inventoryByBrand as $brand)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-ivory-300">{{ $brand->name }}</span>
                        <div class="flex items-center gap-3">
                            <div class="w-24 h-1.5 bg-ebony-600/50 rounded-full overflow-hidden">
                                <div class="h-full bg-gold-500 rounded-full" style="width: {{ ($brand->count / $totalPianos) * 100 }}%"></div>
                            </div>
                            <span class="text-sm text-ebony-400 w-6 text-right">{{ $brand->count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Rental Stats --}}
        <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
            <h2 class="text-lg font-display font-semibold text-ivory-100 mb-4">Rental Statistics</h2>
            <dl class="space-y-4">
                <div class="flex justify-between">
                    <dt class="text-sm text-ebony-400">Active Rentals</dt>
                    <dd class="text-sm font-semibold text-ivory-100">{{ $activeRentals }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-ebony-400">Avg. Rental Duration</dt>
                    <dd class="text-sm font-semibold text-ivory-100">{{ $avgRentalDuration ? number_format($avgRentalDuration, 1) . ' months' : 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-ebony-400">Monthly Rental Revenue</dt>
                    <dd class="text-sm font-semibold text-ivory-100">${{ number_format($rentalRevenue / 100, 0) }}</dd>
                </div>
            </dl>
        </div>
    </div>

</x-layouts.admin>
