<x-layouts.storefront :title="'Order ' . $order->order_number">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-2xl font-bold text-ebony-800">Order {{ $order->order_number }}</h1>
                <p class="text-sm font-ui text-ivory-600 mt-1">Placed {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>
            <a href="{{ route('portal.orders') }}" class="text-sm font-ui text-gold-600 hover:text-gold-500 transition">&larr; All Orders</a>
        </div>

        @include('portal._nav')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Status --}}
                <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-display text-lg font-semibold text-ebony-800">Status</h2>
                        <span class="px-3 py-1 rounded-full text-xs font-ui font-bold bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-700 uppercase">{{ $order->status_label }}</span>
                    </div>
                    @php
                        $steps = ['pending', 'confirmed', 'processing', 'ready_for_delivery', 'delivered', 'completed'];
                        $currentIndex = array_search($order->status, $steps);
                    @endphp
                    <div class="flex items-center gap-1">
                        @foreach($steps as $i => $step)
                            <div class="flex-1 h-2 rounded-full {{ $i <= ($currentIndex ?? -1) ? 'bg-gold-500' : 'bg-ivory-300' }}"></div>
                        @endforeach
                    </div>
                    <div class="flex justify-between mt-2">
                        <span class="text-xs font-ui text-ivory-600">Placed</span>
                        <span class="text-xs font-ui text-ivory-600">Complete</span>
                    </div>
                </div>

                {{-- Items --}}
                <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Items</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-4 p-3 rounded-lg bg-ivory-50">
                                @if($item->piano && $item->piano->primaryPhoto)
                                    <img src="{{ Storage::url($item->piano->primaryPhoto->path) }}" alt="{{ $item->piano->name }}" class="w-16 h-16 rounded-lg object-cover">
                                @else
                                    <div class="w-16 h-16 rounded-lg bg-ivory-200 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-ivory-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v13.5A1.5 1.5 0 003.75 21z"/></svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="text-sm font-ui font-medium text-ebony-800">{{ $item->piano->name ?? 'Piano' }}</p>
                                    <p class="text-xs font-ui text-ivory-600">{{ $item->piano->brand->name ?? '' }} &middot; {{ $item->piano->sku ?? '' }}</p>
                                </div>
                                <p class="text-sm font-ui font-semibold text-ebony-800">${{ number_format($item->price / 100, 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Payment History --}}
                @if($order->payments->count())
                    <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                        <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Payments</h2>
                        <div class="space-y-3">
                            @foreach($order->payments as $payment)
                                <div class="flex items-center justify-between py-2 border-b border-ivory-200/50 last:border-0">
                                    <div>
                                        <p class="text-sm font-ui font-medium text-ebony-800">{{ $payment->type_label }}</p>
                                        <p class="text-xs font-ui text-ivory-600">{{ $payment->paid_at?->format('M j, Y') ?? $payment->created_at->format('M j, Y') }}</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-ui bg-{{ $payment->status_color }}-100 text-{{ $payment->status_color }}-700">{{ $payment->status_label }}</span>
                                        <span class="text-sm font-ui font-semibold text-ebony-800">{{ $payment->formatted_amount }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Delivery --}}
                @if($order->deliveryTasks->count())
                    <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                        <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Delivery</h2>
                        <div class="space-y-3">
                            @foreach($order->deliveryTasks as $task)
                                <div class="flex items-center justify-between py-2">
                                    <div>
                                        <p class="text-sm font-ui font-medium text-ebony-800">{{ ucfirst($task->type) }}</p>
                                        <p class="text-xs font-ui text-ivory-600">{{ $task->scheduled_date?->format('M j, Y') ?? 'Not scheduled' }}</p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-xs font-ui font-medium bg-{{ $task->status === 'completed' ? 'green' : ($task->status === 'scheduled' ? 'blue' : 'yellow') }}-100 text-{{ $task->status === 'completed' ? 'green' : ($task->status === 'scheduled' ? 'blue' : 'yellow') }}-700">{{ ucfirst($task->status) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Order Summary --}}
                <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Order Summary</h2>
                    <div class="space-y-2 text-sm font-ui">
                        <div class="flex justify-between">
                            <span class="text-ivory-600">Subtotal</span>
                            <span class="text-ebony-800">{{ $order->formatted_subtotal }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-ivory-600">Tax</span>
                            <span class="text-ebony-800">{{ $order->formatted_tax }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-ivory-600">Delivery</span>
                            <span class="text-ebony-800">{{ $order->formatted_delivery_fee }}</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-ivory-300 font-semibold">
                            <span class="text-ebony-800">Total</span>
                            <span class="text-ebony-800">{{ $order->formatted_total }}</span>
                        </div>
                    </div>
                </div>

                {{-- Delivery Address --}}
                @if($order->delivery_address)
                    <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                        <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Delivery Address</h2>
                        <div class="text-sm font-ui text-ivory-700 space-y-1">
                            @if($order->delivery_address['line_1'] ?? false)<p>{{ $order->delivery_address['line_1'] }}</p>@endif
                            @if($order->delivery_address['line_2'] ?? false)<p>{{ $order->delivery_address['line_2'] }}</p>@endif
                            <p>{{ $order->delivery_address['city'] ?? '' }}, {{ $order->delivery_address['state'] ?? '' }} {{ $order->delivery_address['zip'] ?? '' }}</p>
                        </div>
                    </div>
                @endif

                {{-- Invoices --}}
                @if($order->invoices->count())
                    <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                        <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Invoices</h2>
                        <div class="space-y-2">
                            @foreach($order->invoices as $invoice)
                                <div class="flex items-center justify-between text-sm font-ui">
                                    <span class="text-ivory-700">{{ $invoice->invoice_number }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-xs bg-{{ $invoice->status_color }}-100 text-{{ $invoice->status_color }}-700">{{ $invoice->status_label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.storefront>
