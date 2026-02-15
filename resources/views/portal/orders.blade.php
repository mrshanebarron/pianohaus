<x-layouts.storefront :title="'My Orders'">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-2xl font-bold text-ebony-800">My Orders</h1>
                <p class="text-sm font-ui text-ivory-600 mt-1">Track your piano purchases</p>
            </div>
            <a href="{{ route('portal.dashboard') }}" class="text-sm font-ui text-gold-600 hover:text-gold-500 transition">&larr; Back to Dashboard</a>
        </div>

        @include('portal._nav')

        @if($orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->count())
            <div class="space-y-4">
                @foreach($orders as $order)
                    <a href="{{ route('portal.orders.show', $order) }}" class="block bg-white rounded-xl border border-ivory-400/50 p-5 hover:border-gold-400/50 hover:shadow-md transition group">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-ebony-50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-ebony-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-ui font-semibold text-ebony-800 group-hover:text-gold-700">{{ $order->order_number }}</p>
                                    <p class="text-xs font-ui text-ivory-600">{{ $order->created_at->format('M j, Y \a\t g:i A') }} &middot; {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 sm:gap-6">
                                <span class="px-2.5 py-1 rounded-full text-xs font-ui font-medium bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-700">{{ $order->status_label }}</span>
                                <span class="text-lg font-display font-bold text-ebony-800">{{ $order->formatted_total }}</span>
                                <svg class="w-4 h-4 text-ivory-500 group-hover:text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </div>
                        </div>
                        @if($order->items->count())
                            <div class="mt-3 pt-3 border-t border-ivory-200/50 flex flex-wrap gap-2">
                                @foreach($order->items as $item)
                                    <span class="text-xs font-ui text-ivory-600 bg-ivory-100 px-2 py-1 rounded">{{ $item->piano->name ?? 'Piano' }}</span>
                                @endforeach
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl border border-ivory-400/50 p-12 text-center">
                <svg class="w-12 h-12 text-ivory-400 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/></svg>
                <h3 class="font-display text-lg font-semibold text-ebony-800 mb-2">No Orders Yet</h3>
                <p class="text-sm font-ui text-ivory-600 mb-6">Browse our curated collection of pianos and find your perfect instrument.</p>
                <a href="{{ route('catalog.sale') }}" class="inline-flex items-center gap-2 bg-gold-500 hover:bg-gold-400 text-ebony-900 font-ui font-semibold px-6 py-2.5 rounded-lg transition">Browse Pianos</a>
            </div>
        @endif
    </div>

</x-layouts.storefront>
