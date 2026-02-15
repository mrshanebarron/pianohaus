<x-layouts.storefront title="Browse Pianos">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="font-display text-3xl font-bold text-ebony-800 mb-2">
                @if(request('type') === 'sale')
                    Pianos for Sale
                @elseif(request('type') === 'rental')
                    Pianos for Rent
                @else
                    All Pianos
                @endif
            </h1>
            <p class="text-sm font-ui text-ivory-700">{{ $pianos->total() }} pianos found</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Sidebar Filters --}}
            <aside class="w-full lg:w-64 flex-shrink-0" x-data="{ filtersOpen: false }">
                <button @click="filtersOpen = !filtersOpen" class="lg:hidden w-full flex items-center justify-between px-4 py-3 bg-white border border-ivory-400/50 rounded-lg text-sm font-ui font-medium text-ebony-800 mb-4">
                    <span>Filters</span>
                    <svg :class="filtersOpen && 'rotate-180'" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </button>

                <form method="GET" action="{{ request()->routeIs('catalog.sale') ? route('catalog.sale') : (request()->routeIs('catalog.rent') ? route('catalog.rent') : route('catalog')) }}" :class="filtersOpen ? 'block' : 'hidden lg:block'" class="space-y-6">
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif

                    {{-- Search --}}
                    <div>
                        <label class="block text-xs font-ui font-semibold text-ebony-700 uppercase tracking-wider mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Piano name or brand..."
                               class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 placeholder-ivory-500 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                    </div>

                    {{-- Brand --}}
                    <div>
                        <label class="block text-xs font-ui font-semibold text-ebony-700 uppercase tracking-wider mb-2">Brand</label>
                        <select name="brand" class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->slug }}" {{ request('brand') === $brand->slug ? 'selected' : '' }}>{{ $brand->name }} ({{ $brand->pianos_count }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-xs font-ui font-semibold text-ebony-700 uppercase tracking-wider mb-2">Category</label>
                        <select name="category" class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->name }} ({{ $category->pianos_count }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Condition --}}
                    <div>
                        <label class="block text-xs font-ui font-semibold text-ebony-700 uppercase tracking-wider mb-2">Condition</label>
                        <select name="condition" class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                            <option value="">Any Condition</option>
                            @foreach($conditions as $key => $label)
                                <option value="{{ $key }}" {{ request('condition') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price Range --}}
                    @if(!request()->routeIs('catalog.rent'))
                    <div>
                        <label class="block text-xs font-ui font-semibold text-ebony-700 uppercase tracking-wider mb-2">Price Range</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="${{ number_format($priceRange['min']) }}"
                                   class="w-full bg-white border border-ivory-400/50 rounded-lg px-3 py-2 text-sm font-ui text-ebony-800 placeholder-ivory-500 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                            <span class="text-ivory-500 text-sm">—</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="${{ number_format($priceRange['max']) }}"
                                   class="w-full bg-white border border-ivory-400/50 rounded-lg px-3 py-2 text-sm font-ui text-ebony-800 placeholder-ivory-500 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                        </div>
                    </div>
                    @endif

                    {{-- Sort --}}
                    <div>
                        <label class="block text-xs font-ui font-semibold text-ebony-700 uppercase tracking-wider mb-2">Sort By</label>
                        <select name="sort" class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="price_low" {{ $sort === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ $sort === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Name: A-Z</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-gold-500 text-ebony-900 font-ui font-semibold text-sm py-2.5 rounded-lg hover:bg-gold-400 transition-colors">
                            Apply Filters
                        </button>
                        <a href="{{ request()->routeIs('catalog.sale') ? route('catalog.sale') : (request()->routeIs('catalog.rent') ? route('catalog.rent') : route('catalog')) }}" class="px-4 py-2.5 border border-ivory-400/50 text-ivory-700 font-ui text-sm rounded-lg hover:bg-ivory-200 transition">
                            Clear
                        </a>
                    </div>
                </form>
            </aside>

            {{-- Piano Grid --}}
            <div class="flex-1">
                @if($pianos->isEmpty())
                    <div class="text-center py-16 bg-white border border-ivory-400/50 rounded-xl">
                        <svg class="w-16 h-16 text-ivory-400 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                        <h3 class="font-display text-lg font-semibold text-ebony-800 mb-1">No pianos found</h3>
                        <p class="text-sm font-ui text-ivory-700">Try adjusting your filters or search terms.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                        @foreach($pianos as $piano)
                            <a href="{{ route('piano.show', $piano) }}" class="group bg-white rounded-xl border border-ivory-400/50 overflow-hidden hover:shadow-lg hover:border-gold-300/50 transition-all duration-300">
                                <div class="aspect-[4/3] bg-ivory-200 overflow-hidden relative">
                                    @if($piano->primary_photo_url)
                                        <img src="{{ $piano->primary_photo_url }}" alt="{{ $piano->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-ivory-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                                        </div>
                                    @endif
                                    {{-- Badges --}}
                                    <div class="absolute top-3 left-3 flex gap-1.5">
                                        @if($piano->has_discount)
                                            <span class="px-2 py-0.5 bg-burgundy-700 text-white text-xs font-ui font-bold rounded">{{ $piano->discount_percent }}% OFF</span>
                                        @endif
                                        @if($piano->is_certified)
                                            <span class="px-2 py-0.5 bg-green-700 text-white text-xs font-ui font-bold rounded">Certified</span>
                                        @endif
                                    </div>
                                    {{-- Type badges --}}
                                    <div class="absolute bottom-3 right-3 flex gap-1.5">
                                        @if($piano->canBePurchased())
                                            <span class="px-2 py-0.5 bg-ebony-900/80 text-ivory-200 text-xs font-ui font-medium rounded backdrop-blur-sm">Buy</span>
                                        @endif
                                        @if($piano->canBeRented())
                                            <span class="px-2 py-0.5 bg-gold-500/90 text-ebony-900 text-xs font-ui font-medium rounded backdrop-blur-sm">Rent</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="text-xs font-ui font-medium text-gold-600 uppercase tracking-wider">{{ $piano->brand->name }}</span>
                                        <span class="text-ivory-400">&middot;</span>
                                        <span class="text-xs font-ui text-ivory-600">{{ $piano->condition_label }}</span>
                                    </div>
                                    <h3 class="font-display text-base font-semibold text-ebony-800 group-hover:text-gold-700 transition-colors mb-1.5">{{ $piano->name }}</h3>
                                    @if($piano->review_count > 0)
                                        <div class="flex items-center gap-1.5 mb-2">
                                            <div class="flex text-gold-500">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= round($piano->average_rating) ? 'fill-current' : 'text-ivory-400' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                            </div>
                                            <span class="text-xs font-ui text-ivory-600">({{ $piano->review_count }})</span>
                                        </div>
                                    @endif
                                    <div class="flex items-baseline justify-between pt-2 border-t border-ivory-300/50">
                                        @if($piano->canBePurchased())
                                            <span class="text-lg font-display font-bold text-ebony-800">{{ $piano->formatted_sale_price }}</span>
                                        @else
                                            <span></span>
                                        @endif
                                        @if($piano->canBeRented())
                                            <span class="text-sm font-ui text-gold-600 font-medium">{{ $piano->formatted_rental_price }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $pianos->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.storefront>
