<x-layouts.admin title="Contract {{ $contract->contract_number }}">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.contracts.index') }}" class="text-ebony-400 hover:text-ivory-300 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </a>
        <div class="flex-1">
            <h2 class="text-xl font-display font-semibold text-ivory-100">{{ $contract->contract_number }}</h2>
            <p class="text-sm text-ebony-400">{{ $contract->customer->full_name ?? 'N/A' }} &middot; {{ ucfirst(str_replace('_', ' ', $contract->type)) }}</p>
        </div>
        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $contract->status_color }}-500/20 text-{{ $contract->status_color }}-400">{{ $contract->status_label }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Contract Content</h3>
            <div class="bg-ebony-800/50 rounded-lg p-6 text-sm text-ivory-300 leading-relaxed font-body whitespace-pre-wrap">{{ $contract->content }}</div>
        </div>

        <div class="space-y-6">
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Signature</h3>
                @if($contract->customer_signed_at)
                    <div class="text-sm text-green-400 mb-2">Signed {{ $contract->customer_signed_at->format('M j, Y g:ia') }}</div>
                    <div class="text-xs text-ebony-400">IP: {{ $contract->customer_ip }}</div>
                    @if($contract->customer_signature)
                        <div class="mt-3 bg-white rounded-lg p-3">
                            <img src="{{ $contract->customer_signature }}" alt="Signature" class="max-h-20">
                        </div>
                    @endif
                @else
                    <p class="text-sm text-yellow-400">Awaiting signature</p>
                @endif
            </div>

            @if($contract->rental)
                <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Linked Rental</h3>
                    <div class="text-sm text-ivory-100">{{ $contract->rental->rental_number }}</div>
                    <div class="text-sm text-ebony-400 mt-1">{{ $contract->rental->piano->name ?? 'N/A' }}</div>
                    <a href="{{ route('admin.rentals.show', $contract->rental) }}" class="inline-block mt-3 text-xs text-gold-400 hover:text-gold-300">View Rental</a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
