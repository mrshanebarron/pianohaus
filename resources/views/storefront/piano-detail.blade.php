<x-layouts.storefront :title="$piano->name">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-sm font-ui text-ivory-600 mb-6">
            <a href="{{ route('home') }}" class="hover:text-gold-600 transition">Home</a>
            <svg class="w-3.5 h-3.5 text-ivory-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <a href="{{ route('catalog') }}" class="hover:text-gold-600 transition">Pianos</a>
            <svg class="w-3.5 h-3.5 text-ivory-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <span class="text-ebony-800">{{ $piano->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- Photo Gallery (3 cols) --}}
            <div class="lg:col-span-3" x-data="{ activePhoto: 0 }">
                {{-- Main Photo --}}
                <div class="aspect-[4/3] bg-ivory-200 rounded-xl overflow-hidden mb-3">
                    @if($piano->photos->isNotEmpty())
                        @foreach($piano->photos as $i => $photo)
                            <img x-show="activePhoto === {{ $i }}" src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->alt_text ?? $piano->name }}" class="w-full h-full object-cover">
                        @endforeach
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-24 h-24 text-ivory-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                        </div>
                    @endif
                </div>
                {{-- Thumbnails --}}
                @if($piano->photos->count() > 1)
                    <div class="flex gap-2 overflow-x-auto pb-1">
                        @foreach($piano->photos as $i => $photo)
                            <button @click="activePhoto = {{ $i }}" :class="activePhoto === {{ $i }} ? 'ring-2 ring-gold-500' : 'ring-1 ring-ivory-400/50'" class="w-20 h-16 rounded-lg overflow-hidden flex-shrink-0 transition">
                                <img src="{{ asset('storage/' . $photo->path) }}" alt="" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Details (2 cols) --}}
            <div class="lg:col-span-2">
                {{-- Brand & Category --}}
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-sm font-ui font-medium text-gold-600 uppercase tracking-wider">{{ $piano->brand->name }}</span>
                    <span class="text-ivory-400">&middot;</span>
                    <span class="text-sm font-ui text-ivory-600">{{ $piano->category->name }}</span>
                </div>

                <h1 class="font-display text-2xl md:text-3xl font-bold text-ebony-800 mb-3">{{ $piano->name }}</h1>

                {{-- Rating --}}
                @if($piano->review_count > 0)
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex text-gold-500">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($piano->average_rating) ? 'fill-current' : 'text-ivory-400' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-sm font-ui text-ivory-600">{{ $piano->average_rating }} ({{ $piano->review_count }} reviews)</span>
                    </div>
                @endif

                {{-- Price --}}
                <div class="bg-ivory-200/50 border border-ivory-400/30 rounded-xl p-5 mb-6">
                    @if($piano->canBePurchased())
                        <div class="mb-3">
                            <span class="text-xs font-ui font-semibold text-ivory-600 uppercase tracking-wider">Sale Price</span>
                            <div class="flex items-baseline gap-3 mt-1">
                                <span class="text-3xl font-display font-bold text-ebony-800">{{ $piano->formatted_sale_price }}</span>
                                @if($piano->has_discount)
                                    <span class="text-lg text-ivory-600 line-through">{{ $piano->formatted_original_price }}</span>
                                    <span class="px-2 py-0.5 bg-burgundy-100 text-burgundy-700 text-xs font-ui font-bold rounded">Save {{ $piano->discount_percent }}%</span>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if($piano->canBeRented())
                        <div class="{{ $piano->canBePurchased() ? 'pt-3 border-t border-ivory-400/30' : '' }}">
                            <span class="text-xs font-ui font-semibold text-ivory-600 uppercase tracking-wider">Monthly Rental</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-display font-bold text-gold-700">{{ $piano->formatted_rental_price }}</span>
                                <span class="text-sm font-ui text-ivory-600">+ {{ $piano->formatted_rental_deposit }} deposit</span>
                            </div>
                            <p class="text-xs text-ivory-600 font-ui mt-1">Min. {{ $rentalTerms['minimum_months'] }} months &middot; {{ (int)($rentalTerms['rent_to_own_credit'] * 100) }}% rent-to-own credit</p>
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-3 mb-6">
                    @if($piano->canBePurchased())
                        <form method="POST" action="{{ route('cart.add', $piano) }}">
                            @csrf
                            <button type="submit" class="w-full bg-gold-500 text-ebony-900 font-ui font-semibold py-3.5 rounded-lg hover:bg-gold-400 transition-colors text-base">
                                Add to Cart
                            </button>
                        </form>
                    @endif
                    @if($piano->canBeRented())
                        <a href="{{ route('rental.apply', $piano) }}" class="w-full inline-flex items-center justify-center border-2 border-gold-500 text-gold-700 font-ui font-semibold py-3 rounded-lg hover:bg-gold-50 transition-colors text-base">
                            Apply to Rent
                        </a>
                    @endif
                </div>

                {{-- Specs --}}
                <div class="border border-ivory-400/30 rounded-xl overflow-hidden mb-6">
                    <div class="bg-ivory-200/50 px-5 py-3 border-b border-ivory-400/30">
                        <h3 class="text-sm font-ui font-semibold text-ebony-800 uppercase tracking-wider">Specifications</h3>
                    </div>
                    <dl class="divide-y divide-ivory-300/50">
                        <div class="flex justify-between px-5 py-3">
                            <dt class="text-sm font-ui text-ivory-600">Brand</dt>
                            <dd class="text-sm font-ui font-medium text-ebony-800">{{ $piano->brand->name }}</dd>
                        </div>
                        <div class="flex justify-between px-5 py-3">
                            <dt class="text-sm font-ui text-ivory-600">Category</dt>
                            <dd class="text-sm font-ui font-medium text-ebony-800">{{ $piano->category->name }}</dd>
                        </div>
                        <div class="flex justify-between px-5 py-3">
                            <dt class="text-sm font-ui text-ivory-600">Year</dt>
                            <dd class="text-sm font-ui font-medium text-ebony-800">{{ $piano->year ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex justify-between px-5 py-3">
                            <dt class="text-sm font-ui text-ivory-600">Condition</dt>
                            <dd class="text-sm font-ui font-medium text-ebony-800">{{ $piano->condition_label }}</dd>
                        </div>
                        @if($piano->finish)
                        <div class="flex justify-between px-5 py-3">
                            <dt class="text-sm font-ui text-ivory-600">Finish</dt>
                            <dd class="text-sm font-ui font-medium text-ebony-800">{{ $piano->finish }}</dd>
                        </div>
                        @endif
                        @if($piano->serial_number)
                        <div class="flex justify-between px-5 py-3">
                            <dt class="text-sm font-ui text-ivory-600">Serial Number</dt>
                            <dd class="text-sm font-ui font-medium text-ebony-800">{{ $piano->serial_number }}</dd>
                        </div>
                        @endif
                        <div class="flex justify-between px-5 py-3">
                            <dt class="text-sm font-ui text-ivory-600">SKU</dt>
                            <dd class="text-sm font-ui font-medium text-ebony-800">{{ $piano->sku }}</dd>
                        </div>
                        @if($piano->dimensions)
                        <div class="flex justify-between px-5 py-3">
                            <dt class="text-sm font-ui text-ivory-600">Dimensions</dt>
                            <dd class="text-sm font-ui font-medium text-ebony-800">
                                {{ $piano->dimensions['width'] ?? '' }}" W x {{ $piano->dimensions['depth'] ?? '' }}" D x {{ $piano->dimensions['height'] ?? '' }}" H
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>

                {{-- Features --}}
                @if($piano->features)
                <div class="mb-6">
                    <h3 class="text-sm font-ui font-semibold text-ebony-800 uppercase tracking-wider mb-3">Features</h3>
                    <ul class="space-y-1.5">
                        @foreach($piano->features as $feature)
                            <li class="flex items-start gap-2 text-sm text-ivory-700">
                                <svg class="w-4 h-4 text-gold-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Includes --}}
                @if($piano->includes)
                <div class="mb-6">
                    <h3 class="text-sm font-ui font-semibold text-ebony-800 uppercase tracking-wider mb-3">Includes</h3>
                    <ul class="space-y-1.5">
                        @foreach($piano->includes as $item)
                            <li class="flex items-start gap-2 text-sm text-ivory-700">
                                <svg class="w-4 h-4 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Badges --}}
                <div class="flex flex-wrap gap-2">
                    @if($piano->is_certified)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-green-700 text-xs font-ui font-medium rounded-lg border border-green-200">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                            Certified Pre-Owned
                        </span>
                    @endif
                    @if($piano->is_featured)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gold-50 text-gold-700 text-xs font-ui font-medium rounded-lg border border-gold-200">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd"/></svg>
                            Featured
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Description --}}
        @if($piano->description)
        <div class="mt-10 max-w-3xl">
            <h2 class="font-display text-xl font-semibold text-ebony-800 mb-4">About This Piano</h2>
            <div class="prose prose-ivory text-ivory-700 font-body leading-relaxed">
                {!! nl2br(e($piano->description)) !!}
            </div>
        </div>
        @endif

        {{-- Reviews --}}
        <div class="mt-12" x-data="{ showReviewForm: false }">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display text-xl font-semibold text-ebony-800">
                    Reviews
                    @if($piano->approvedReviews->isNotEmpty())
                        <span class="text-base font-normal text-ivory-600">({{ $piano->approvedReviews->count() }})</span>
                    @endif
                </h2>
                <button @click="showReviewForm = !showReviewForm" class="text-sm font-ui font-medium text-gold-600 hover:text-gold-700 transition">
                    Write a Review
                </button>
            </div>

            {{-- Review Form --}}
            <div x-show="showReviewForm" x-cloak x-transition class="bg-white border border-ivory-400/50 rounded-xl p-6 mb-8">
                <h3 class="font-display text-lg font-semibold text-ebony-800 mb-4">Write Your Review</h3>
                <form method="POST" action="{{ route('reviews.store', $piano) }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Your Name</label>
                            <input type="text" name="name" id="name" required class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                        </div>
                        <div>
                            <label for="review_email" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Email</label>
                            <input type="email" name="email" id="review_email" required class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">Rating</label>
                        <div x-data="{ rating: 5 }" class="flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" @click="rating = {{ $i }}" class="focus:outline-none">
                                    <svg :class="rating >= {{ $i }} ? 'text-gold-500 fill-current' : 'text-ivory-400'" class="w-7 h-7 transition" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </button>
                            @endfor
                            <input type="hidden" name="rating" x-model="rating">
                        </div>
                    </div>
                    <div>
                        <label for="review_title" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Review Title</label>
                        <input type="text" name="title" id="review_title" required class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="review_body" class="block text-sm font-ui font-medium text-ebony-700 mb-1">Your Review</label>
                        <textarea name="body" id="review_body" rows="4" required class="w-full bg-white border border-ivory-400/50 rounded-lg px-3.5 py-2.5 text-sm font-ui text-ebony-800 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none resize-none"></textarea>
                    </div>
                    <button type="submit" class="bg-gold-500 text-ebony-900 font-ui font-semibold text-sm px-6 py-2.5 rounded-lg hover:bg-gold-400 transition-colors">
                        Submit Review
                    </button>
                </form>
            </div>

            {{-- Review List --}}
            @if($piano->approvedReviews->isNotEmpty())
                <div class="space-y-4">
                    @foreach($piano->approvedReviews as $review)
                        <div class="bg-white border border-ivory-400/50 rounded-xl p-5">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="flex text-gold-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-ivory-400' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                    <h4 class="font-ui font-semibold text-sm text-ebony-800">{{ $review->title }}</h4>
                                    @if($review->is_verified_purchase)
                                        <span class="px-2 py-0.5 bg-green-50 text-green-700 text-xs font-ui font-medium rounded border border-green-200">Verified Purchase</span>
                                    @endif
                                </div>
                                <span class="text-xs font-ui text-ivory-600">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-ivory-700 font-body leading-relaxed mb-2">{{ $review->body }}</p>
                            <span class="text-xs font-ui text-ivory-500">— {{ $review->customer->full_name ?? 'Anonymous' }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-white border border-ivory-400/50 rounded-xl">
                    <p class="text-sm font-ui text-ivory-600">No reviews yet. Be the first to share your experience!</p>
                </div>
            @endif
        </div>

        {{-- Related Pianos --}}
        @if($related->isNotEmpty())
        <div class="mt-12">
            <h2 class="font-display text-xl font-semibold text-ebony-800 mb-6">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($related as $rPiano)
                    <a href="{{ route('piano.show', $rPiano) }}" class="group bg-white rounded-xl border border-ivory-400/50 overflow-hidden hover:shadow-lg hover:border-gold-300/50 transition-all duration-300">
                        <div class="aspect-[4/3] bg-ivory-200 overflow-hidden">
                            @if($rPiano->primary_photo_url)
                                <img src="{{ $rPiano->primary_photo_url }}" alt="{{ $rPiano->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-ivory-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <span class="text-xs font-ui font-medium text-gold-600 uppercase tracking-wider">{{ $rPiano->brand->name }}</span>
                            <h3 class="font-display text-sm font-semibold text-ebony-800 group-hover:text-gold-700 transition-colors mt-1">{{ $rPiano->name }}</h3>
                            <div class="mt-2">
                                @if($rPiano->canBePurchased())
                                    <span class="text-base font-display font-bold text-ebony-800">{{ $rPiano->formatted_sale_price }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    @push('styles')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Product",
        "name": "{{ e($piano->name) }}",
        "description": "{{ e(Str::limit(strip_tags($piano->description), 200)) }}",
        "brand": { "@@type": "Brand", "name": "{{ e($piano->brand->name) }}" },
        "category": "{{ e($piano->category->name) }}",
        "sku": "{{ e($piano->sku) }}",
        @if($piano->primary_photo_url)
        "image": "{{ $piano->primary_photo_url }}",
        @endif
        @if($piano->canBePurchased())
        "offers": {
            "@@type": "Offer",
            "price": "{{ number_format($piano->sale_price / 100, 2, '.', '') }}",
            "priceCurrency": "USD",
            "availability": "https://schema.org/{{ $piano->status === 'available' ? 'InStock' : 'OutOfStock' }}",
            "itemCondition": "https://schema.org/UsedCondition"
        },
        @endif
        @if($piano->review_count > 0)
        "aggregateRating": {
            "@@type": "AggregateRating",
            "ratingValue": "{{ $piano->average_rating }}",
            "reviewCount": "{{ $piano->review_count }}"
        },
        @endif
        "manufacturer": { "@@type": "Organization", "name": "{{ e($piano->brand->name) }}" }
    }
    </script>
    @endpush

</x-layouts.storefront>
