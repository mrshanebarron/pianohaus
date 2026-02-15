<x-layouts.admin title="Rental {{ $rental->rental_number }}">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.rentals.index') }}" class="text-ebony-400 hover:text-ivory-300 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-display font-semibold text-ivory-100">{{ $rental->rental_number }}</h2>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $rental->status_color }}-500/20 text-{{ $rental->status_color }}-400">{{ $rental->status_label }}</span>
            </div>
            <p class="text-sm text-ebony-400">{{ $rental->piano->name ?? 'N/A' }}</p>
        </div>
        @if($rental->status === 'pending_application')
            <div class="flex gap-2">
                <form method="POST" action="{{ route('admin.rentals.approve', $rental) }}">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-500 transition font-medium">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.rentals.deny', $rental) }}">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-500 transition font-medium">Deny</button>
                </form>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Rental Details --}}
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Rental Details</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-xs text-ebony-400 mb-1">Monthly Rate</dt><dd class="text-sm font-semibold text-ivory-100">{{ $rental->formatted_monthly_rate }}</dd></div>
                    <div><dt class="text-xs text-ebony-400 mb-1">Deposit</dt><dd class="text-sm font-semibold text-ivory-100">{{ $rental->formatted_deposit }}</dd></div>
                    <div><dt class="text-xs text-ebony-400 mb-1">Start Date</dt><dd class="text-sm text-ivory-300">{{ $rental->start_date?->format('M j, Y') ?? 'Pending' }}</dd></div>
                    <div><dt class="text-xs text-ebony-400 mb-1">Min End Date</dt><dd class="text-sm text-ivory-300">{{ $rental->minimum_end_date?->format('M j, Y') ?? 'N/A' }}</dd></div>
                    <div><dt class="text-xs text-ebony-400 mb-1">Deposit Paid</dt><dd class="text-sm {{ $rental->deposit_paid ? 'text-green-400' : 'text-yellow-400' }}">{{ $rental->deposit_paid ? 'Yes' : 'No' }}</dd></div>
                    <div><dt class="text-xs text-ebony-400 mb-1">Total Paid</dt><dd class="text-sm font-semibold text-ivory-100">${{ number_format($rental->total_paid / 100, 2) }}</dd></div>
                </dl>
            </div>

            {{-- Application Notes --}}
            @if($rental->application_notes)
                <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-3">Application Notes</h3>
                    <p class="text-sm text-ivory-300 leading-relaxed">{{ $rental->application_notes }}</p>
                </div>
            @endif

            {{-- Payments --}}
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Payment History</h3>
                <div class="space-y-2">
                    @forelse($rental->payments as $payment)
                        <div class="flex items-center justify-between p-3 bg-ebony-800/50 rounded-lg">
                            <div>
                                <div class="text-sm text-ivory-100">{{ ucfirst(str_replace('_', ' ', $payment->type)) }}</div>
                                <div class="text-xs text-ebony-400">{{ $payment->paid_at?->format('M j, Y') }}</div>
                            </div>
                            <div class="text-sm font-semibold {{ $payment->type === 'refund' ? 'text-red-400' : 'text-green-400' }}">
                                {{ $payment->type === 'refund' ? '-' : '+' }}${{ number_format($payment->amount / 100, 2) }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-ebony-400 text-center py-4">No payments recorded.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Customer</h3>
                @if($rental->customer)
                    <div class="text-sm font-medium text-ivory-100">{{ $rental->customer->full_name }}</div>
                    <div class="text-sm text-ebony-400 mt-1">{{ $rental->customer->email }}</div>
                    <div class="text-sm text-ebony-400">{{ $rental->customer->phone }}</div>
                    <a href="{{ route('admin.customers.show', $rental->customer) }}" class="inline-block mt-3 text-xs text-gold-400 hover:text-gold-300">View Customer</a>
                @endif
            </div>

            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Piano</h3>
                @if($rental->piano)
                    <div class="text-sm font-medium text-ivory-100">{{ $rental->piano->name }}</div>
                    <div class="text-sm text-ebony-400 mt-1">{{ $rental->piano->brand->name ?? '' }} &middot; {{ $rental->piano->category->name ?? '' }}</div>
                    <a href="{{ route('admin.pianos.show', $rental->piano) }}" class="inline-block mt-3 text-xs text-gold-400 hover:text-gold-300">View Piano</a>
                @endif
            </div>

            @if($rental->contract)
                <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Contract</h3>
                    <div class="text-sm text-ivory-100">{{ $rental->contract->contract_number }}</div>
                    <div class="text-sm text-ebony-400 mt-1">
                        Status: <span class="text-{{ $rental->contract->status_color }}-400">{{ $rental->contract->status_label }}</span>
                    </div>
                    <a href="{{ route('admin.contracts.show', $rental->contract) }}" class="inline-block mt-3 text-xs text-gold-400 hover:text-gold-300">View Contract</a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
