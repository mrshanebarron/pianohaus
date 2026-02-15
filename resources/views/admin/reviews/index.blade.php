<x-layouts.admin title="Reviews">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <p class="text-sm text-ebony-400">{{ $reviews->total() }} reviews</p>
            @if($pendingCount > 0)
                <a href="{{ route('admin.reviews.index', ['filter' => 'pending']) }}"
                   class="px-3 py-1 rounded-full text-xs font-medium {{ request('filter') === 'pending' ? 'bg-yellow-500/30 text-yellow-300' : 'bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30' }} transition">
                    {{ $pendingCount }} pending
                </a>
            @endif
        </div>
        @if(request('filter'))
            <a href="{{ route('admin.reviews.index') }}" class="text-xs text-ebony-400 hover:text-ivory-300">Show all</a>
        @endif
    </div>

    <div class="space-y-3">
        @forelse($reviews as $review)
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-5 {{ !$review->is_approved ? 'border-yellow-500/20' : '' }}">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <div class="flex text-gold-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-ebony-600' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <span class="text-sm font-medium text-ivory-100">{{ $review->title }}</span>
                            @if(!$review->is_approved)
                                <span class="px-2 py-0.5 rounded text-xs bg-yellow-500/20 text-yellow-400">Pending</span>
                            @endif
                            @if($review->is_verified_purchase)
                                <span class="px-2 py-0.5 rounded text-xs bg-green-500/20 text-green-400">Verified</span>
                            @endif
                        </div>
                        <div class="text-xs text-ebony-400">
                            {{ $review->customer->full_name ?? 'Anonymous' }} on
                            <a href="{{ route('admin.pianos.show', $review->piano) }}" class="text-gold-400 hover:text-gold-300">{{ $review->piano->name ?? 'N/A' }}</a>
                            &middot; {{ $review->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="flex gap-2">
                        @if(!$review->is_approved)
                            <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-green-600/80 text-white rounded text-xs hover:bg-green-600 transition">Approve</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600/80 text-white rounded text-xs hover:bg-red-600 transition">Delete</button>
                        </form>
                    </div>
                </div>
                <p class="text-sm text-ivory-300 leading-relaxed">{{ $review->body }}</p>
            </div>
        @empty
            <div class="text-center py-8 text-ebony-400">No reviews found.</div>
        @endforelse
    </div>
    <div class="mt-4">{{ $reviews->withQueryString()->links() }}</div>
</x-layouts.admin>
