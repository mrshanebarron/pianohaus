<x-layouts.storefront title="Checkout">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <h1 class="font-display text-3xl font-bold text-ebony-800 mb-8">Checkout</h1>

        <form method="POST" action="{{ route('checkout.process') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            {{-- Customer & Delivery Info --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Contact Information --}}
                <div class="bg-white border border-ivory-400/50 rounded-xl p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Contact Information</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-ui font-medium text-ebony-700 mb-1">First Name</label>
                            <input type="text" name="first_name" id="first_name" required value="{{ old('first_name') }}"
                                   class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                            @error('first_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Last Name</label>
                            <input type="text" name="last_name" id="last_name" required value="{{ old('last_name') }}"
                                   class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                            @error('last_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                   class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                            @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Phone</label>
                            <input type="tel" name="phone" id="phone" required value="{{ old('phone') }}"
                                   class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                            @error('phone') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Delivery Address --}}
                <div class="bg-white border border-ivory-400/50 rounded-xl p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Delivery Address</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="address_line_1" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Address Line 1</label>
                            <input type="text" name="address_line_1" id="address_line_1" required value="{{ old('address_line_1') }}"
                                   class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                            @error('address_line_1') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="address_line_2" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Address Line 2 <span class="text-ivory-500">(optional)</span></label>
                            <input type="text" name="address_line_2" id="address_line_2" value="{{ old('address_line_2') }}"
                                   class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-ui font-medium text-ebony-700 mb-1">City</label>
                                <input type="text" name="city" id="city" required value="{{ old('city') }}"
                                       class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                                @error('city') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="state" class="block text-sm font-ui font-medium text-ebony-700 mb-1">State</label>
                                <input type="text" name="state" id="state" required value="{{ old('state') }}"
                                       class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                                @error('state') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="zip" class="block text-sm font-ui font-medium text-ebony-700 mb-1">ZIP</label>
                                <input type="text" name="zip" id="zip" required value="{{ old('zip') }}"
                                       class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                                @error('zip') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="delivery_notes" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Delivery Notes <span class="text-ivory-500">(optional)</span></label>
                            <textarea name="delivery_notes" id="delivery_notes" rows="2" class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none resize-none" placeholder="Gate code, preferred entrance, etc.">{{ old('delivery_notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Payment (Demo) --}}
                <div class="bg-white border border-ivory-400/50 rounded-xl p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Payment</h2>
                    <div class="bg-gold-50 border border-gold-200 rounded-lg px-4 py-3 text-sm font-ui text-gold-800">
                        <strong>Demo Mode:</strong> Payment is simulated. No real charges will be made. In production, Stripe payment fields would appear here.
                    </div>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 opacity-50 pointer-events-none">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">Card Number</label>
                            <input type="text" value="4242 4242 4242 4242" disabled class="w-full bg-ivory-200 border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800">
                        </div>
                        <div>
                            <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">Expiry</label>
                            <input type="text" value="12/29" disabled class="w-full bg-ivory-200 border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800">
                        </div>
                        <div>
                            <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">CVC</label>
                            <input type="text" value="123" disabled class="w-full bg-ivory-200 border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div>
                <div class="bg-white border border-ivory-400/50 rounded-xl p-6 sticky top-24">
                    <h3 class="font-display text-lg font-semibold text-ebony-800 mb-4">Order Summary</h3>

                    <div class="space-y-3 mb-4">
                        @foreach($items as $item)
                            <div class="flex justify-between text-sm font-ui">
                                <span class="text-ivory-700 truncate mr-2">{{ $item['name'] }}</span>
                                <span class="font-medium text-ebony-800 whitespace-nowrap">${{ number_format($item['price'] / 100, 0) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <dl class="space-y-2 text-sm font-ui pt-3 border-t border-ivory-400/30">
                        <div class="flex justify-between">
                            <dt class="text-ivory-600">Subtotal</dt>
                            <dd class="font-medium text-ebony-800">{{ $subtotal }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-ivory-600">Tax</dt>
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

                    <button type="submit" class="block w-full mt-6 bg-gold-500 text-ebony-900 font-ui font-semibold text-center py-3.5 rounded-lg hover:bg-gold-400 transition-colors">
                        Place Order &mdash; {{ $total }}
                    </button>
                    <a href="{{ route('cart') }}" class="block w-full mt-3 text-center text-sm font-ui text-ivory-600 hover:text-gold-600 transition">
                        Back to Cart
                    </a>
                </div>
            </div>
        </form>
    </div>

</x-layouts.storefront>
