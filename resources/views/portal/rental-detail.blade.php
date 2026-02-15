<x-layouts.storefront :title="'Rental ' . $rental->rental_number">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-2xl font-bold text-ebony-800">Rental {{ $rental->rental_number }}</h1>
                <p class="text-sm font-ui text-ivory-600 mt-1">Applied {{ $rental->created_at->format('F j, Y') }}</p>
            </div>
            <a href="{{ route('portal.rentals') }}" class="text-sm font-ui text-gold-600 hover:text-gold-500 transition">&larr; All Rentals</a>
        </div>

        @include('portal._nav')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Piano --}}
                <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Instrument</h2>
                    <div class="flex items-center gap-4">
                        @if($rental->piano && $rental->piano->primaryPhoto)
                            <img src="{{ Storage::url($rental->piano->primaryPhoto->path) }}" alt="{{ $rental->piano->name }}" class="w-24 h-24 rounded-lg object-cover">
                        @else
                            <div class="w-24 h-24 rounded-lg bg-ivory-200 flex items-center justify-center">
                                <svg class="w-10 h-10 text-ivory-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                            </div>
                        @endif
                        <div>
                            <p class="font-display text-lg font-semibold text-ebony-800">{{ $rental->piano->name ?? 'Piano' }}</p>
                            <p class="text-sm font-ui text-ivory-600">{{ $rental->piano->brand->name ?? '' }} &middot; {{ $rental->piano->category->name ?? '' }}</p>
                            @if($rental->piano)
                                <p class="text-sm font-ui text-ivory-600 mt-1">{{ $rental->piano->year ?? '' }} &middot; {{ ucfirst($rental->piano->condition ?? '') }} &middot; {{ $rental->piano->finish ?? '' }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Rental Terms --}}
                <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Rental Terms</h2>
                    <div class="grid grid-cols-2 gap-4 text-sm font-ui">
                        <div>
                            <p class="text-ivory-600">Monthly Rate</p>
                            <p class="text-ebony-800 font-semibold text-lg">{{ $rental->formatted_monthly_rate }}</p>
                        </div>
                        <div>
                            <p class="text-ivory-600">Security Deposit</p>
                            <p class="text-ebony-800 font-semibold text-lg">{{ $rental->formatted_deposit }}</p>
                        </div>
                        <div>
                            <p class="text-ivory-600">Start Date</p>
                            <p class="text-ebony-800 font-medium">{{ $rental->start_date?->format('M j, Y') ?? 'Pending' }}</p>
                        </div>
                        <div>
                            <p class="text-ivory-600">End Date</p>
                            <p class="text-ebony-800 font-medium">{{ $rental->end_date?->format('M j, Y') ?? 'Pending' }}</p>
                        </div>
                        @if($rental->duration_months)
                            <div>
                                <p class="text-ivory-600">Duration</p>
                                <p class="text-ebony-800 font-medium">{{ $rental->duration_months }} months</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-ivory-600">Total Paid</p>
                            <p class="text-ebony-800 font-medium">${{ number_format($rental->total_paid / 100, 2) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Contract --}}
                @if($rental->contract)
                    <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                        <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Contract</h2>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-ui font-medium text-ebony-800">{{ $rental->contract->contract_number }}</p>
                                <p class="text-xs font-ui text-ivory-600">
                                    @if($rental->contract->customer_signed_at)
                                        Signed {{ $rental->contract->customer_signed_at->format('M j, Y') }}
                                    @else
                                        Awaiting signature
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-2.5 py-1 rounded-full text-xs font-ui font-medium bg-{{ $rental->contract->status_color }}-100 text-{{ $rental->contract->status_color }}-700">{{ $rental->contract->status_label }}</span>
                                @if(!$rental->contract->customer_signed_at && $rental->contract->status !== 'voided')
                                    <a href="{{ route('contract.sign', $rental->contract) }}" class="bg-gold-500 hover:bg-gold-400 text-ebony-900 text-xs font-ui font-semibold px-4 py-2 rounded-lg transition">Sign Now</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Payment History --}}
                @if($rental->payments->count())
                    <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                        <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Payment History</h2>
                        <div class="space-y-3">
                            @foreach($rental->payments as $payment)
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
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Status Card --}}
                <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Status</h2>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1.5 rounded-full text-sm font-ui font-bold bg-{{ $rental->status_color }}-100 text-{{ $rental->status_color }}-700">{{ $rental->status_label }}</span>
                    </div>
                    @if($rental->approved_at)
                        <p class="text-xs font-ui text-ivory-600 mt-3">Approved {{ $rental->approved_at->format('M j, Y') }}</p>
                    @endif
                    @if($rental->next_payment_date)
                        <div class="mt-4 pt-4 border-t border-ivory-300">
                            <p class="text-xs font-ui text-ivory-600">Next Payment</p>
                            <p class="text-sm font-ui font-semibold text-ebony-800">{{ $rental->next_payment_date->format('M j, Y') }}</p>
                        </div>
                    @endif
                </div>

                {{-- Rent-to-Own Info --}}
                @php
                    $creditPercent = config('pianohaus.rental.rent_to_own_credit_percent', 0);
                    $totalPaid = $rental->total_paid;
                    $creditAmount = (int) ($totalPaid * $creditPercent / 100);
                @endphp
                @if($creditPercent > 0 && $rental->piano)
                    <div class="bg-gold-50 rounded-xl border border-gold-200 p-6">
                        <h2 class="font-display text-lg font-semibold text-gold-900 mb-2">Rent-to-Own</h2>
                        <p class="text-sm font-ui text-gold-800 mb-3">{{ $creditPercent }}% of your rental payments can be applied toward purchasing this piano.</p>
                        <div class="space-y-2 text-sm font-ui">
                            <div class="flex justify-between">
                                <span class="text-gold-700">Total Paid</span>
                                <span class="text-gold-900 font-medium">${{ number_format($totalPaid / 100, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gold-700">Credit Earned</span>
                                <span class="text-gold-900 font-semibold">${{ number_format($creditAmount / 100, 2) }}</span>
                            </div>
                            @if($rental->piano->sale_price)
                                <div class="flex justify-between pt-2 border-t border-gold-300">
                                    <span class="text-gold-700">Purchase Price</span>
                                    <span class="text-gold-900 font-medium">${{ number_format($rental->piano->sale_price / 100, 2) }}</span>
                                </div>
                                <div class="flex justify-between font-semibold">
                                    <span class="text-gold-700">Your Price</span>
                                    <span class="text-gold-900">${{ number_format(max(0, $rental->piano->sale_price - $creditAmount) / 100, 2) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.storefront>
