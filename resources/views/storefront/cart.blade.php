<x-layouts.storefront title="Shopping Cart">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <h1 class="font-display text-3xl font-bold text-ebony-800 mb-8">Shopping Cart</h1>

        @if($isEmpty)
            <div class="text-center py-16 bg-white border border-ivory-400/50 rounded-xl">
                <svg class="w-16 h-16 text-ivory-400 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                <h2 class="font-display text-lg font-semibold text-ebony-800 mb-2">Your cart is empty</h2>
                <p class="text-sm font-ui text-ivory-700 mb-6">Browse our collection to find your perfect piano.</p>
                <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-gold-500 text-ebony-900 font-ui font-semibold px-6 py-2.5 rounded-lg hover:bg-gold-400 transition-colors">
                    Browse Pianos
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Cart Items --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($items as $item)
                        <div class="bg-white border border-ivory-400/50 rounded-xl p-5 flex gap-5">
                            <div class="w-28 h-20 bg-ivory-200 rounded-lg overflow-hidden flex-shrink-0">
                                @if($item['piano']->primary_photo_url)
                                    <img src="{{ $item['piano']->primary_photo_url }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-ivory-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <span class="text-xs font-ui font-medium text-gold-600 uppercase tracking-wider">{{ $item['brand'] }}</span>
                                        <h3 class="font-display text-base font-semibold text-ebony-800 mt-0.5">
                                            <a href="{{ route('piano.show', $item['piano']) }}" class="hover:text-gold-700 transition">{{ $item['name'] }}</a>
                                        </h3>
                                        <p class="text-xs font-ui text-ivory-600 mt-0.5">SKU: {{ $item['sku'] }}</p>
                                    </div>
                                    <span class="text-lg font-display font-bold text-ebony-800">{{ $item['formatted_price'] }}</span>
                                </div>
                                <div class="mt-3">
                                    <form method="POST" action="{{ route('cart.remove', $item['piano']) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-ui text-red-600 hover:text-red-700 transition">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Summary --}}
                <div>
                    <div class="bg-white border border-ivory-400/50 rounded-xl p-6 sticky top-24">
                        <h3 class="font-display text-lg font-semibold text-ebony-800 mb-4">Order Summary</h3>
                        <dl class="space-y-3 text-sm font-ui">
                            <div class="flex justify-between">
                                <dt class="text-ivory-600">Subtotal</dt>
                                <dd class="font-medium text-ebony-800">{{ $subtotal }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-ivory-600">Tax ({{ config('pianohaus.tax_rate') * 100 }}%)</dt>
                                <dd class="font-medium text-ebony-800">{{ $tax }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-ivory-600">Delivery</dt>
                                <dd class="font-medium text-ebony-800">{{ $deliveryFee }}</dd>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-ivory-400/30">
                                <dt class="font-semibold text-ebony-800">Total</dt>
                                <dd class="font-bold text-lg text-ebony-800">{{ $total }}</dd>
                            </div>
                        </dl>
                        <a href="{{ route('checkout') }}" class="block w-full mt-6 bg-gold-500 text-ebony-900 font-ui font-semibold text-center py-3 rounded-lg hover:bg-gold-400 transition-colors">
                            Proceed to Checkout
                        </a>
                        <a href="{{ route('catalog') }}" class="block w-full mt-3 text-center text-sm font-ui text-ivory-600 hover:text-gold-600 transition">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

</x-layouts.storefront>
