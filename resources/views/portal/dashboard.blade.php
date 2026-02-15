<x-layouts.storefront :title="'My Account'">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Portal Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-2xl font-bold text-ebony-800">Welcome Back{{ isset($customer) ? ', ' . $customer->first_name : '' }}</h1>
                <p class="text-sm font-ui text-ivory-600 mt-1">Manage your orders, rentals, and account details</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm font-ui text-ivory-600 hover:text-burgundy-600 transition">Sign Out</button>
            </form>
        </div>

        @include('portal._nav')

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl border border-ivory-400/50 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-bold text-ebony-800">{{ $stats['orders'] ?? 0 }}</p>
                        <p class="text-xs font-ui text-ivory-600">Orders</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-ivory-400/50 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-bold text-ebony-800">{{ $stats['rentals'] ?? 0 }}</p>
                        <p class="text-xs font-ui text-ivory-600">Rentals</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-ivory-400/50 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-bold text-ebony-800">{{ $stats['documents'] ?? 0 }}</p>
                        <p class="text-xs font-ui text-ivory-600">Documents</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-ivory-400/50 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gold-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gold-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-display font-bold text-ebony-800">{{ isset($customer) ? $customer->formatted_total_spent : '$0.00' }}</p>
                        <p class="text-xs font-ui text-ivory-600">Total Spent</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Next Payment Due --}}
            <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Next Payment</h2>
                @if($nextPaymentDue)
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm font-ui">
                            <span class="text-ivory-600">Invoice</span>
                            <span class="text-ebony-800 font-medium">{{ $nextPaymentDue->invoice_number }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-ui">
                            <span class="text-ivory-600">Amount</span>
                            <span class="text-ebony-800 font-semibold">{{ $nextPaymentDue->formatted_balance_due }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-ui">
                            <span class="text-ivory-600">Due Date</span>
                            <span class="{{ $nextPaymentDue->is_overdue ? 'text-red-600 font-semibold' : 'text-ebony-800' }}">{{ $nextPaymentDue->due_date->format('M j, Y') }}</span>
                        </div>
                        @if($nextPaymentDue->is_overdue)
                            <p class="text-xs font-ui text-red-600 bg-red-50 rounded-lg px-3 py-2">This payment is overdue. Please contact us to arrange payment.</p>
                        @endif
                    </div>
                @else
                    <p class="text-sm font-ui text-ivory-600">No payments currently due.</p>
                @endif
            </div>

            {{-- Active Rentals --}}
            <div class="lg:col-span-2 bg-white rounded-xl border border-ivory-400/50 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-display text-lg font-semibold text-ebony-800">Active Rentals</h2>
                    <a href="{{ route('portal.rentals') }}" class="text-sm font-ui text-gold-600 hover:text-gold-500 transition">View All</a>
                </div>
                @if($activeRentals->count())
                    <div class="space-y-3">
                        @foreach($activeRentals as $rental)
                            <a href="{{ route('portal.rentals.show', $rental) }}" class="flex items-center gap-4 p-3 rounded-lg hover:bg-ivory-50 transition group">
                                @if($rental->piano->primaryPhoto)
                                    <img src="{{ Storage::url($rental->piano->primaryPhoto->path) }}" alt="{{ $rental->piano->name }}" class="w-14 h-14 rounded-lg object-cover">
                                @else
                                    <div class="w-14 h-14 rounded-lg bg-ivory-200 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-ivory-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v13.5A1.5 1.5 0 003.75 21z"/></svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-ui font-medium text-ebony-800 group-hover:text-gold-700 truncate">{{ $rental->piano->name }}</p>
                                    <p class="text-xs font-ui text-ivory-600">{{ $rental->formatted_monthly_rate }}/mo &middot; {{ $rental->rental_number }}</p>
                                </div>
                                <svg class="w-4 h-4 text-ivory-500 group-hover:text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm font-ui text-ivory-600">No active rentals. <a href="{{ route('catalog.rent') }}" class="text-gold-600 hover:text-gold-500">Browse pianos for rent</a></p>
                @endif
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="mt-6 bg-white rounded-xl border border-ivory-400/50 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-display text-lg font-semibold text-ebony-800">Recent Orders</h2>
                <a href="{{ route('portal.orders') }}" class="text-sm font-ui text-gold-600 hover:text-gold-500 transition">View All</a>
            </div>
            @if($recentOrders->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm font-ui">
                        <thead>
                            <tr class="border-b border-ivory-300">
                                <th class="text-left py-2.5 text-ivory-600 font-medium">Order</th>
                                <th class="text-left py-2.5 text-ivory-600 font-medium">Date</th>
                                <th class="text-left py-2.5 text-ivory-600 font-medium">Items</th>
                                <th class="text-right py-2.5 text-ivory-600 font-medium">Total</th>
                                <th class="text-center py-2.5 text-ivory-600 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr class="border-b border-ivory-200/50 hover:bg-ivory-50 transition">
                                    <td class="py-3">
                                        <a href="{{ route('portal.orders.show', $order) }}" class="text-gold-700 hover:text-gold-500 font-medium">{{ $order->order_number }}</a>
                                    </td>
                                    <td class="py-3 text-ivory-700">{{ $order->created_at->format('M j, Y') }}</td>
                                    <td class="py-3 text-ivory-700">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</td>
                                    <td class="py-3 text-right font-medium text-ebony-800">{{ $order->formatted_total }}</td>
                                    <td class="py-3 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-700">{{ $order->status_label }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm font-ui text-ivory-600">No orders yet. <a href="{{ route('catalog.sale') }}" class="text-gold-600 hover:text-gold-500">Browse pianos for sale</a></p>
            @endif
        </div>
    </div>

</x-layouts.storefront>
