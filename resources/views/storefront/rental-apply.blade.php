<x-layouts.storefront :title="'Rent ' . $piano->name">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-sm font-ui text-ivory-600 mb-6">
            <a href="{{ route('home') }}" class="hover:text-gold-600 transition">Home</a>
            <svg class="w-3.5 h-3.5 text-ivory-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <a href="{{ route('piano.show', $piano) }}" class="hover:text-gold-600 transition">{{ $piano->name }}</a>
            <svg class="w-3.5 h-3.5 text-ivory-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <span class="text-ebony-800">Rental Application</span>
        </nav>

        <h1 class="font-display text-3xl font-bold text-ebony-800 mb-2">Rental Application</h1>
        <p class="text-sm font-ui text-ivory-700 mb-8">Complete the form below to apply for a rental of the <strong>{{ $piano->name }}</strong>.</p>

        <form method="POST" action="{{ route('rental.apply.store', $piano) }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            {{-- Application Form --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Contact Information --}}
                <div class="bg-white border border-ivory-400/50 rounded-xl p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Your Information</h2>
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
                    </div>
                </div>

                {{-- Rental Details --}}
                <div class="bg-white border border-ivory-400/50 rounded-xl p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Rental Details</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Preferred Start Date</label>
                            <input type="date" name="start_date" id="start_date" required value="{{ old('start_date') }}" min="{{ now()->addDay()->format('Y-m-d') }}"
                                   class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                            @error('start_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="duration_months" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Duration (months)</label>
                            <select name="duration_months" id="duration_months" required
                                    class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                                @for($m = $rentalTerms['minimum_months']; $m <= 24; $m++)
                                    <option value="{{ $m }}" {{ old('duration_months', 6) == $m ? 'selected' : '' }}>{{ $m }} months</option>
                                @endfor
                            </select>
                            @error('duration_months') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="application_notes" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Additional Notes <span class="text-ivory-500">(optional)</span></label>
                        <textarea name="application_notes" id="application_notes" rows="3" class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none resize-none" placeholder="Tell us about your experience level, intended use, etc.">{{ old('application_notes') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Piano Summary Sidebar --}}
            <div>
                <div class="bg-white border border-ivory-400/50 rounded-xl overflow-hidden sticky top-24">
                    <div class="aspect-[4/3] bg-ivory-200 overflow-hidden">
                        @if($piano->primary_photo_url)
                            <img src="{{ $piano->primary_photo_url }}" alt="{{ $piano->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-ivory-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <span class="text-xs font-ui font-medium text-gold-600 uppercase tracking-wider">{{ $piano->brand->name }}</span>
                        <h3 class="font-display text-lg font-semibold text-ebony-800 mt-1 mb-3">{{ $piano->name }}</h3>

                        <dl class="space-y-2.5 text-sm font-ui">
                            <div class="flex justify-between">
                                <dt class="text-ivory-600">Monthly Rate</dt>
                                <dd class="font-semibold text-ebony-800">{{ $piano->formatted_rental_price }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-ivory-600">Security Deposit</dt>
                                <dd class="font-semibold text-ebony-800">{{ $piano->formatted_rental_deposit }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-ivory-600">Min. Term</dt>
                                <dd class="font-semibold text-ebony-800">{{ $rentalTerms['minimum_months'] }} months</dd>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-ivory-400/30">
                                <dt class="text-ivory-600">Rent-to-Own Credit</dt>
                                <dd class="font-semibold text-gold-700">{{ (int)($rentalTerms['rent_to_own_credit'] * 100) }}%</dd>
                            </div>
                        </dl>

                        <button type="submit" class="block w-full mt-5 bg-gold-500 text-ebony-900 font-ui font-semibold text-center py-3 rounded-lg hover:bg-gold-400 transition-colors">
                            Submit Application
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</x-layouts.storefront>
