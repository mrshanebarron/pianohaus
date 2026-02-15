<x-layouts.storefront title="Fine Used Pianos">

    {{-- Hero --}}
    <section class="relative bg-ebony-900 overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/hero-piano.jpg') }}" alt="Grand piano in elegant setting" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-ebony-900 via-ebony-900/85 to-ebony-900/50"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-36">
            <div class="max-w-2xl">
                <p class="text-gold-400 font-ui text-sm font-semibold tracking-widest uppercase mb-4">Nashville's Premier Piano Gallery</p>
                <h1 class="font-display text-4xl md:text-6xl font-bold text-ivory-100 leading-tight mb-6">
                    Find Your <span class="italic text-gold-400">Perfect</span> Piano
                </h1>
                <p class="text-lg text-ivory-400 font-body leading-relaxed mb-8 max-w-lg">
                    Curated collection of premium used pianos from the world's finest makers. Buy outright or rent with the option to own.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('catalog.sale') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-gold-500 text-ebony-900 font-ui font-semibold rounded-lg hover:bg-gold-400 transition-colors">
                        Browse Pianos for Sale
                    </a>
                    <a href="{{ route('catalog.rent') }}" class="inline-flex items-center justify-center px-8 py-3.5 border-2 border-ivory-400/30 text-ivory-200 font-ui font-semibold rounded-lg hover:border-gold-400 hover:text-gold-400 transition-colors">
                        Explore Rentals
                    </a>
                </div>
            </div>
        </div>
        {{-- Stats bar --}}
        <div class="relative border-t border-ebony-700/50 bg-ebony-900/80 backdrop-blur">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
                <div class="flex flex-wrap justify-center gap-8 md:gap-16">
                    <div class="text-center">
                        <div class="text-2xl font-display font-bold text-gold-400">{{ $stats['pianos'] }}+</div>
                        <div class="text-xs font-ui text-ivory-500 uppercase tracking-wider mt-1">Pianos Available</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-display font-bold text-gold-400">{{ $stats['brands'] }}</div>
                        <div class="text-xs font-ui text-ivory-500 uppercase tracking-wider mt-1">Premium Brands</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-display font-bold text-gold-400">{{ $stats['reviews'] }}</div>
                        <div class="text-xs font-ui text-ivory-500 uppercase tracking-wider mt-1">Happy Customers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-display font-bold text-gold-400">50%</div>
                        <div class="text-xs font-ui text-ivory-500 uppercase tracking-wider mt-1">Rent-to-Own Credit</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Pianos --}}
    @if($featured->isNotEmpty())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-gold-600 font-ui text-sm font-semibold tracking-widest uppercase mb-2">Hand-Selected</p>
                <h2 class="font-display text-3xl font-bold text-ebony-800">Featured Pianos</h2>
            </div>
            <a href="{{ route('catalog') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-ui font-medium text-gold-600 hover:text-gold-700 transition">
                View All
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featured as $piano)
                <a href="{{ route('piano.show', $piano) }}" class="group bg-white rounded-xl border border-ivory-400/50 overflow-hidden hover:shadow-lg hover:border-gold-300/50 transition-all duration-300">
                    <div class="aspect-[4/3] bg-ivory-200 overflow-hidden relative">
                        @if($piano->primary_photo_url)
                            <img src="{{ $piano->primary_photo_url }}" alt="{{ $piano->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-ivory-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                            </div>
                        @endif
                        @if($piano->has_discount)
                            <div class="absolute top-3 left-3 px-2.5 py-1 bg-burgundy-700 text-white text-xs font-ui font-bold rounded">{{ $piano->discount_percent }}% OFF</div>
                        @endif
                        @if($piano->is_certified)
                            <div class="absolute top-3 right-3 px-2.5 py-1 bg-green-700 text-white text-xs font-ui font-bold rounded">Certified</div>
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-ui font-medium text-gold-600 uppercase tracking-wider">{{ $piano->brand->name }}</span>
                            <span class="text-ivory-400">&middot;</span>
                            <span class="text-xs font-ui text-ivory-600">{{ $piano->category->name }}</span>
                        </div>
                        <h3 class="font-display text-lg font-semibold text-ebony-800 group-hover:text-gold-700 transition-colors mb-2">{{ $piano->name }}</h3>
                        <div class="flex items-center gap-2 mb-3">
                            @if($piano->review_count > 0)
                                <div class="flex text-gold-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= round($piano->average_rating) ? 'fill-current' : 'text-ivory-400' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <span class="text-xs font-ui text-ivory-600">{{ $piano->average_rating }} ({{ $piano->review_count }})</span>
                            @endif
                        </div>
                        <div class="flex items-baseline justify-between">
                            <div>
                                @if($piano->canBePurchased())
                                    <span class="text-xl font-display font-bold text-ebony-800">{{ $piano->formatted_sale_price }}</span>
                                    @if($piano->has_discount)
                                        <span class="text-sm text-ivory-600 line-through ml-2">{{ $piano->formatted_original_price }}</span>
                                    @endif
                                @endif
                            </div>
                            @if($piano->canBeRented())
                                <span class="text-sm font-ui text-gold-600 font-medium">{{ $piano->formatted_rental_price }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 text-sm font-ui font-medium text-gold-600 hover:text-gold-700 transition">
                View All Pianos
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
    </section>
    @endif

    {{-- Categories --}}
    @if($categories->isNotEmpty())
    <section class="bg-ebony-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <p class="text-gold-400 font-ui text-sm font-semibold tracking-widest uppercase mb-2">Browse by Type</p>
                <h2 class="font-display text-3xl font-bold text-ivory-100">Piano Categories</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('catalog', ['category' => $category->slug]) }}" class="group bg-ebony-800 border border-ebony-700/50 rounded-xl p-6 text-center hover:border-gold-500/50 hover:bg-ebony-700/60 transition-all duration-300">
                        <div class="w-12 h-12 bg-gold-500/20 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-gold-500/30 transition">
                            <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                        </div>
                        <h3 class="font-display text-base font-semibold text-ivory-100 mb-1">{{ $category->name }}</h3>
                        <p class="text-xs font-ui text-ivory-500">{{ $category->pianos_count }} available</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- How It Works --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <p class="text-gold-600 font-ui text-sm font-semibold tracking-widest uppercase mb-2">Simple Process</p>
            <h2 class="font-display text-3xl font-bold text-ebony-800">Buy or Rent in Three Steps</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-14 h-14 bg-gold-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="font-display text-xl font-bold text-gold-700">1</span>
                </div>
                <h3 class="font-display text-lg font-semibold text-ebony-800 mb-2">Browse & Select</h3>
                <p class="text-sm text-ivory-700 leading-relaxed">Explore our curated collection. Filter by brand, type, condition, and price to find your perfect match.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-gold-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="font-display text-xl font-bold text-gold-700">2</span>
                </div>
                <h3 class="font-display text-lg font-semibold text-ebony-800 mb-2">Purchase or Apply</h3>
                <p class="text-sm text-ivory-700 leading-relaxed">Buy outright with secure payment, or submit a rental application. We review applications within 24 hours.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-gold-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="font-display text-xl font-bold text-gold-700">3</span>
                </div>
                <h3 class="font-display text-lg font-semibold text-ebony-800 mb-2">Delivery & Setup</h3>
                <p class="text-sm text-ivory-700 leading-relaxed">Professional delivery and setup included. Every piano is tuned and inspected before arriving at your door.</p>
            </div>
        </div>
    </section>

    {{-- Rent-to-Own CTA --}}
    <section class="bg-gradient-to-br from-ebony-800 to-ebony-900 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-gold-500/20 rounded-full mb-6">
                <svg class="w-4 h-4 text-gold-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                <span class="text-sm font-ui font-medium text-gold-300">Rent-to-Own Available</span>
            </div>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-ivory-100 mb-4">Not Ready to Buy? Rent First.</h2>
            <p class="text-lg text-ivory-400 font-body leading-relaxed mb-8 max-w-2xl mx-auto">
                Start with a monthly rental and apply <strong class="text-gold-400">50% of your payments</strong> toward purchasing the piano. No commitment, no risk.
                Minimum {{ config('pianohaus.rental.minimum_months') }}-month term.
            </p>
            <a href="{{ route('catalog.rent') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-gold-500 text-ebony-900 font-ui font-semibold rounded-lg hover:bg-gold-400 transition-colors">
                View Rental Pianos
            </a>
        </div>
    </section>

    {{-- Testimonials --}}
    @if($reviews->isNotEmpty())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-10">
            <p class="text-gold-600 font-ui text-sm font-semibold tracking-widest uppercase mb-2">Customer Stories</p>
            <h2 class="font-display text-3xl font-bold text-ebony-800">What Our Customers Say</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($reviews as $review)
                <div class="bg-white border border-ivory-400/50 rounded-xl p-6">
                    <div class="flex text-gold-500 mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-ivory-400' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <h3 class="font-display text-base font-semibold text-ebony-800 mb-2">{{ $review->title }}</h3>
                    <p class="text-sm text-ivory-700 leading-relaxed mb-4">{{ Str::limit($review->body, 150) }}</p>
                    <div class="flex items-center justify-between text-xs font-ui text-ivory-600">
                        <span>{{ $review->customer->full_name }}</span>
                        <span>on {{ $review->piano->name ?? 'N/A' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Brands --}}
    @if($brands->isNotEmpty())
    <section class="bg-ivory-200/50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-ui font-semibold text-ivory-600 uppercase tracking-widest mb-6">Trusted Brands We Carry</p>
            <div class="flex flex-wrap items-center justify-center gap-8 md:gap-12">
                @foreach($brands as $brand)
                    <a href="{{ route('catalog', ['brand' => $brand->slug]) }}" class="text-lg font-display font-semibold text-ivory-600 hover:text-gold-600 transition">
                        {{ $brand->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @push('styles')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Store",
        "name": "{{ config('pianohaus.company.name') }}",
        "description": "{{ config('pianohaus.company.tagline') }}",
        "url": "{{ url('/') }}",
        "telephone": "{{ config('pianohaus.company.phone') }}",
        "email": "{{ config('pianohaus.company.email') }}",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "{{ config('pianohaus.company.address') }}"
        },
        "priceRange": "$$",
        "openingHoursSpecification": {
            "@@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
            "opens": "10:00",
            "closes": "18:00"
        }
    }
    </script>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('gsap-ready');
            gsap.registerPlugin(ScrollTrigger);

            // Hero entrance
            const heroTl = gsap.timeline();
            heroTl.from('.relative.bg-ebony-900 p:first-child', { y: 30, autoAlpha: 0, duration: 0.6, ease: 'power3.out' })
                   .from('.relative.bg-ebony-900 h1', { y: 40, autoAlpha: 0, duration: 0.7, ease: 'power3.out' }, '-=0.3')
                   .from('.relative.bg-ebony-900 .max-w-2xl > p:nth-child(3)', { y: 30, autoAlpha: 0, duration: 0.6, ease: 'power3.out' }, '-=0.3')
                   .from('.relative.bg-ebony-900 .flex.flex-col', { y: 20, autoAlpha: 0, duration: 0.5, ease: 'power3.out' }, '-=0.2');

            // Stats counter
            document.querySelectorAll('.text-2xl.font-display.font-bold.text-gold-400').forEach(function(el) {
                const text = el.textContent;
                const num = parseInt(text.replace(/\D/g, ''));
                if (isNaN(num)) return;
                const suffix = text.replace(String(num), '');
                gsap.from(el, {
                    textContent: 0,
                    duration: 1.5,
                    ease: 'power2.out',
                    delay: 0.8,
                    snap: { textContent: 1 },
                    onUpdate: function() {
                        el.textContent = Math.round(parseFloat(el.textContent)) + suffix;
                    }
                });
            });

            // Featured piano cards stagger
            gsap.utils.toArray('.grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-3 > a').forEach(function(card, i) {
                const rect = card.getBoundingClientRect();
                if (rect.top < window.innerHeight) {
                    gsap.fromTo(card, { y: 40, autoAlpha: 0 }, { y: 0, autoAlpha: 1, duration: 0.6, delay: 0.3 + i * 0.15, ease: 'power3.out' });
                } else {
                    gsap.set(card, { autoAlpha: 0, y: 40 });
                    ScrollTrigger.create({
                        trigger: card,
                        start: 'top 85%',
                        once: true,
                        onEnter: function() {
                            gsap.to(card, { y: 0, autoAlpha: 1, duration: 0.6, delay: i * 0.1, ease: 'power3.out' });
                        }
                    });
                }
            });

            // Category cards stagger
            gsap.utils.toArray('.bg-ebony-900.py-16 .grid > a').forEach(function(card, i) {
                gsap.set(card, { autoAlpha: 0, y: 30 });
                ScrollTrigger.create({
                    trigger: card,
                    start: 'top 85%',
                    once: true,
                    onEnter: function() {
                        gsap.to(card, { y: 0, autoAlpha: 1, duration: 0.5, delay: i * 0.08, ease: 'power3.out' });
                    }
                });
            });

            // How it works steps
            gsap.utils.toArray('.grid.grid-cols-1.md\\:grid-cols-3 > div').forEach(function(step, i) {
                const rect = step.getBoundingClientRect();
                if (rect.top < window.innerHeight) {
                    gsap.fromTo(step, { y: 30, autoAlpha: 0 }, { y: 0, autoAlpha: 1, duration: 0.5, delay: 0.2 + i * 0.15, ease: 'power3.out' });
                } else {
                    gsap.set(step, { autoAlpha: 0, y: 30 });
                    ScrollTrigger.create({
                        trigger: step,
                        start: 'top 85%',
                        once: true,
                        onEnter: function() {
                            gsap.to(step, { y: 0, autoAlpha: 1, duration: 0.5, delay: i * 0.15, ease: 'power3.out' });
                        }
                    });
                }
            });

            // Testimonial cards
            gsap.utils.toArray('.bg-white.border.border-ivory-400\\/50.rounded-xl.p-6').forEach(function(card, i) {
                const rect = card.getBoundingClientRect();
                if (rect.top < window.innerHeight) return;
                gsap.set(card, { autoAlpha: 0, y: 30 });
                ScrollTrigger.create({
                    trigger: card,
                    start: 'top 85%',
                    once: true,
                    onEnter: function() {
                        gsap.to(card, { y: 0, autoAlpha: 1, duration: 0.5, delay: i * 0.12, ease: 'power3.out' });
                    }
                });
            });

            // Rent-to-Own CTA section
            const ctaSection = document.querySelector('.bg-gradient-to-br');
            if (ctaSection) {
                const ctaRect = ctaSection.getBoundingClientRect();
                if (ctaRect.top >= window.innerHeight) {
                    gsap.set(ctaSection.children[0], { autoAlpha: 0, y: 40 });
                    ScrollTrigger.create({
                        trigger: ctaSection,
                        start: 'top 75%',
                        once: true,
                        onEnter: function() {
                            gsap.to(ctaSection.children[0], { y: 0, autoAlpha: 1, duration: 0.7, ease: 'power3.out' });
                        }
                    });
                }
            }
        });
    </script>
    @endpush

</x-layouts.storefront>
