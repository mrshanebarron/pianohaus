<x-layouts.storefront :title="'My Rentals'">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-2xl font-bold text-ebony-800">My Rentals</h1>
                <p class="text-sm font-ui text-ivory-600 mt-1">Manage your piano rental agreements</p>
            </div>
            <a href="{{ route('portal.dashboard') }}" class="text-sm font-ui text-gold-600 hover:text-gold-500 transition">&larr; Back to Dashboard</a>
        </div>

        @include('portal._nav')

        @if($rentals instanceof \Illuminate\Pagination\LengthAwarePaginator && $rentals->count())
            <div class="space-y-4">
                @foreach($rentals as $rental)
                    <a href="{{ route('portal.rentals.show', $rental) }}" class="block bg-white rounded-xl border border-ivory-400/50 p-5 hover:border-gold-400/50 hover:shadow-md transition group">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            @if($rental->piano && $rental->piano->primaryPhoto)
                                <img src="{{ Storage::url($rental->piano->primaryPhoto->path) }}" alt="{{ $rental->piano->name }}" class="w-20 h-20 rounded-lg object-cover">
                            @else
                                <div class="w-20 h-20 rounded-lg bg-ivory-200 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-ivory-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-ui font-semibold text-ebony-800 group-hover:text-gold-700">{{ $rental->piano->name ?? 'Piano' }}</p>
                                <p class="text-xs font-ui text-ivory-600 mt-1">{{ $rental->rental_number }} &middot; {{ $rental->formatted_monthly_rate }}/mo</p>
                                @if($rental->start_date && $rental->end_date)
                                    <p class="text-xs font-ui text-ivory-600 mt-0.5">{{ $rental->start_date->format('M j, Y') }} &mdash; {{ $rental->end_date->format('M j, Y') }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-ui font-medium bg-{{ $rental->status_color }}-100 text-{{ $rental->status_color }}-700">{{ $rental->status_label }}</span>
                                <svg class="w-4 h-4 text-ivory-500 group-hover:text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $rentals->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl border border-ivory-400/50 p-12 text-center">
                <svg class="w-12 h-12 text-ivory-400 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                <h3 class="font-display text-lg font-semibold text-ebony-800 mb-2">No Rentals Yet</h3>
                <p class="text-sm font-ui text-ivory-600 mb-6">Explore our rental collection and start playing today.</p>
                <a href="{{ route('catalog.rent') }}" class="inline-flex items-center gap-2 bg-gold-500 hover:bg-gold-400 text-ebony-900 font-ui font-semibold px-6 py-2.5 rounded-lg transition">Browse Rentals</a>
            </div>
        @endif
    </div>

</x-layouts.storefront>
