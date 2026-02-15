<x-layouts.admin title="{{ $piano->name }}">

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.pianos.index') }}" class="text-ebony-400 hover:text-ivory-300 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-display font-semibold text-ivory-100">{{ $piano->name }}</h2>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $piano->status === 'available' ? 'green' : 'yellow' }}-500/20 text-{{ $piano->status === 'available' ? 'green' : 'yellow' }}-400">{{ ucfirst($piano->status) }}</span>
                @if($piano->is_featured)<span class="px-2 py-0.5 rounded text-xs bg-gold-500/20 text-gold-400">Featured</span>@endif
                @if($piano->is_certified)<span class="px-2 py-0.5 rounded text-xs bg-blue-500/20 text-blue-400">Certified</span>@endif
            </div>
            <p class="text-sm text-ebony-400">{{ $piano->brand->name }} &middot; {{ $piano->category->name }} &middot; SKU: {{ $piano->sku }}</p>
        </div>
        <a href="{{ route('admin.pianos.edit', $piano) }}" class="inline-flex items-center gap-2 bg-gold-500 text-ebony-900 font-semibold px-4 py-2 rounded-lg hover:bg-gold-400 transition text-sm">
            Edit Piano
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Photos --}}
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Photos</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @forelse($piano->photos as $photo)
                        <div class="aspect-square bg-ebony-600/30 rounded-lg overflow-hidden relative group">
                            <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->alt_text }}" class="w-full h-full object-cover">
                            <form method="POST" action="{{ route('admin.pianos.photos.destroy', [$piano, $photo]) }}" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-6 h-6 bg-red-600 rounded-full flex items-center justify-center text-white hover:bg-red-500">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8 text-ebony-400 text-sm">No photos uploaded yet.</div>
                    @endforelse
                </div>
                <form method="POST" action="{{ route('admin.pianos.photos.store', $piano) }}" enctype="multipart/form-data" class="mt-4 flex items-center gap-3">
                    @csrf
                    <input type="file" name="photos[]" multiple accept="image/*" class="text-sm text-ebony-400 file:bg-ebony-600/50 file:text-ivory-300 file:border-0 file:px-3 file:py-1.5 file:rounded-lg file:text-sm file:cursor-pointer">
                    <button type="submit" class="bg-ebony-600/50 text-ivory-300 px-4 py-1.5 rounded-lg text-sm hover:bg-ebony-600 transition">Upload</button>
                </form>
            </div>

            {{-- Description --}}
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-3">Description</h3>
                <div class="prose prose-sm prose-invert max-w-none text-ivory-300 leading-relaxed">
                    {!! nl2br(e($piano->description)) !!}
                </div>
            </div>

            {{-- Reviews --}}
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Reviews ({{ $piano->reviews->count() }})</h3>
                <div class="space-y-4">
                    @forelse($piano->reviews as $review)
                        <div class="p-3 rounded-lg bg-ebony-800/50">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="flex text-gold-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-ebony-600' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-ebony-400">{{ $review->customer->full_name ?? 'Anonymous' }}</span>
                                    @if(!$review->is_approved)
                                        <span class="px-1.5 py-0.5 rounded text-xs bg-yellow-500/20 text-yellow-400">Pending</span>
                                    @endif
                                </div>
                            </div>
                            <p class="text-sm text-ivory-300 font-medium">{{ $review->title }}</p>
                            <p class="text-sm text-ebony-300 mt-1 line-clamp-2">{{ $review->body }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-ebony-400 text-center py-4">No reviews.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Pricing --}}
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Pricing</h3>
                <div class="space-y-3">
                    @if($piano->sale_price)
                        <div class="flex justify-between">
                            <span class="text-sm text-ebony-400">Sale Price</span>
                            <span class="text-sm font-semibold text-ivory-100">{{ $piano->formatted_sale_price }}</span>
                        </div>
                    @endif
                    @if($piano->original_price)
                        <div class="flex justify-between">
                            <span class="text-sm text-ebony-400">Original Price</span>
                            <span class="text-sm text-ebony-300 line-through">{{ $piano->formatted_original_price }}</span>
                        </div>
                    @endif
                    @if($piano->rental_price_monthly)
                        <div class="flex justify-between">
                            <span class="text-sm text-ebony-400">Monthly Rental</span>
                            <span class="text-sm font-semibold text-ivory-100">{{ $piano->formatted_rental_price }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-ebony-400">Deposit</span>
                            <span class="text-sm text-ivory-300">{{ $piano->formatted_rental_deposit }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Details --}}
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-4">Details</h3>
                <dl class="space-y-3">
                    @foreach([
                        'Year' => $piano->year,
                        'Condition' => $piano->condition_label,
                        'Finish' => $piano->finish,
                        'Serial' => $piano->serial_number,
                        'Type' => ucfirst($piano->type),
                        'Views' => number_format($piano->views_count),
                    ] as $label => $value)
                        @if($value)
                            <div class="flex justify-between">
                                <dt class="text-sm text-ebony-400">{{ $label }}</dt>
                                <dd class="text-sm text-ivory-300">{{ $value }}</dd>
                            </div>
                        @endif
                    @endforeach
                </dl>
            </div>

            {{-- Features --}}
            @if($piano->features)
                <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-3">Features</h3>
                    <ul class="space-y-1.5">
                        @foreach($piano->features as $feature)
                            <li class="text-sm text-ivory-300 flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-gold-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Dimensions --}}
            @if($piano->dimensions)
                <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-3">Dimensions</h3>
                    <dl class="space-y-2">
                        @foreach($piano->dimensions as $key => $val)
                            <div class="flex justify-between">
                                <dt class="text-sm text-ebony-400">{{ ucfirst($key) }}</dt>
                                <dd class="text-sm text-ivory-300">{{ $val }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            @endif
        </div>
    </div>

</x-layouts.admin>
