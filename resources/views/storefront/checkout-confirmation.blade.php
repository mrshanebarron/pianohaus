<x-layouts.storefront title="Order Confirmed">

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Success Icon --}}
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            </div>
            <h1 class="font-display text-3xl font-bold text-ebony-800 mb-2">Order Confirmed!</h1>
            <p class="text-sm font-ui text-ivory-700">Thank you for your purchase. Your order details are below.</p>
        </div>

        {{-- Order Details --}}
        <div class="bg-white border border-ivory-400/50 rounded-xl overflow-hidden">
            <div class="bg-ivory-200/50 px-6 py-4 border-b border-ivory-400/30">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-ui font-semibold text-ivory-600 uppercase tracking-wider">Order Number</span>
                        <p class="text-lg font-display font-bold text-ebony-800">{{ $order->order_number }}</p>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-ui font-bold rounded-full uppercase">{{ $order->status_label }}</span>
                </div>
            </div>

            <div class="p-6">
                {{-- Items --}}
                <h3 class="text-sm font-ui font-semibold text-ebony-700 uppercase tracking-wider mb-3">Items</h3>
                <div class="space-y-3 mb-6">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-sm font-ui font-medium text-ebony-800">{{ $item->piano->name }}</span>
                                <span class="text-xs text-ivory-600 ml-2">{{ $item->piano->brand->name }}</span>
                            </div>
                            <span class="text-sm font-ui font-semibold text-ebony-800">${{ number_format($item->price / 100, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Totals --}}
                <dl class="space-y-2 text-sm font-ui pt-4 border-t border-ivory-400/30">
                    <div class="flex justify-between">
                        <dt class="text-ivory-600">Subtotal</dt>
                        <dd class="text-ebony-800">{{ $order->formatted_subtotal }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ivory-600">Tax</dt>
                        <dd class="text-ebony-800">{{ $order->formatted_tax }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ivory-600">Delivery</dt>
                        <dd class="text-ebony-800">{{ $order->formatted_delivery_fee }}</dd>
                    </div>
                    <div class="flex justify-between pt-3 border-t border-ivory-400/30 font-semibold">
                        <dt class="text-ebony-800">Total Paid</dt>
                        <dd class="text-lg text-ebony-800">{{ $order->formatted_total }}</dd>
                    </div>
                </dl>

                {{-- Customer Info --}}
                <div class="mt-6 pt-4 border-t border-ivory-400/30 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm font-ui">
                    <div>
                        <span class="text-xs font-semibold text-ivory-600 uppercase tracking-wider">Customer</span>
                        <p class="text-ebony-800 mt-1">{{ $order->customer->full_name }}</p>
                        <p class="text-ivory-600">{{ $order->customer->email }}</p>
                        <p class="text-ivory-600">{{ $order->customer->phone }}</p>
                    </div>
                    @if($order->delivery_address)
                    <div>
                        <span class="text-xs font-semibold text-ivory-600 uppercase tracking-wider">Delivery Address</span>
                        <p class="text-ebony-800 mt-1">
                            {{ $order->delivery_address['line_1'] ?? '' }}<br>
                            @if(!empty($order->delivery_address['line_2'])){{ $order->delivery_address['line_2'] }}<br>@endif
                            {{ $order->delivery_address['city'] ?? '' }}, {{ $order->delivery_address['state'] ?? '' }} {{ $order->delivery_address['zip'] ?? '' }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Next Steps --}}
        <div class="bg-gold-50 border border-gold-200 rounded-xl p-6 mt-6">
            <h3 class="font-display text-base font-semibold text-gold-800 mb-3">What Happens Next</h3>
            <ol class="space-y-2 text-sm font-ui text-gold-800">
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 bg-gold-200 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold text-gold-800">1</span>
                    <span>We'll confirm your order and prepare your piano for delivery.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 bg-gold-200 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold text-gold-800">2</span>
                    <span>Our team will contact you to schedule a delivery window.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-5 h-5 bg-gold-200 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold text-gold-800">3</span>
                    <span>Professional movers will deliver and set up your piano. Complimentary tuning included.</span>
                </li>
            </ol>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 text-sm font-ui font-medium text-gold-600 hover:text-gold-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Continue Browsing
            </a>
        </div>
    </div>

</x-layouts.storefront>
