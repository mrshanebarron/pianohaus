<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('pianohaus.company.name') }} — {{ config('pianohaus.company.tagline') }}</title>
    <meta name="description" content="{{ $description ?? 'Browse, purchase, and rent fine used pianos. Curated collection of premium instruments from Steinway, Yamaha, Kawai, and more.' }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ebony: { 50: '#f0f0f4', 100: '#d8d8e2', 200: '#b1b1c5', 300: '#8a8aa8', 400: '#63638b', 500: '#3c3c6e', 600: '#2d2d53', 700: '#1f1f39', 800: '#1a1a2e', 900: '#111120' },
                        gold: { 50: '#fdf9ef', 100: '#f9f0d4', 200: '#f0dca3', 300: '#e6c56d', 400: '#d9ab42', 500: '#c9a959', 600: '#a88632', 700: '#7f6526', 800: '#5a481c', 900: '#3a2f13' },
                        burgundy: { 50: '#fdf2f3', 100: '#fce4e6', 200: '#f5c2c7', 300: '#e89099', 400: '#d4535f', 500: '#b83341', 600: '#9a2533', 700: '#722f37', 800: '#5a252c', 900: '#3f1a1f' },
                        ivory: { 50: '#fefdfb', 100: '#fcfaf5', 200: '#f9f4ea', 300: '#f5f0e8', 400: '#ede6d8', 500: '#e0d8c5', 600: '#c4bca7', 700: '#a39c89', 800: '#827c6b', 900: '#605c4f' },
                    },
                    fontFamily: {
                        display: ['Playfair Display', 'serif'],
                        body: ['Source Serif 4', 'serif'],
                        ui: ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Source+Serif+4:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-ivory-100 font-body text-ebony-800 antialiased">

    {{-- Navigation --}}
    <header x-data="{ mobileMenu: false, cartOpen: false }" class="sticky top-0 z-50 bg-ebony-900/95 backdrop-blur-sm border-b border-ebony-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 bg-gold-500 rounded-lg flex items-center justify-center group-hover:bg-gold-400 transition">
                        <svg class="w-5 h-5 text-ebony-900" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 16H7V5h2v10h2V5h2v10h2V5h2v14z"/></svg>
                    </div>
                    <span class="font-display text-xl font-semibold text-ivory-100 tracking-wide">PianoHaus</span>
                </a>

                {{-- Desktop Nav --}}
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('catalog') }}" class="text-sm font-ui font-medium text-ivory-300 hover:text-gold-400 transition {{ request()->routeIs('catalog') && !request('type') ? 'text-gold-400' : '' }}">All Pianos</a>
                    <a href="{{ route('catalog.sale') }}" class="text-sm font-ui font-medium text-ivory-300 hover:text-gold-400 transition {{ request()->routeIs('catalog.sale') || request('type') === 'sale' ? 'text-gold-400' : '' }}">Buy</a>
                    <a href="{{ route('catalog.rent') }}" class="text-sm font-ui font-medium text-ivory-300 hover:text-gold-400 transition {{ request()->routeIs('catalog.rent') || request('type') === 'rental' ? 'text-gold-400' : '' }}">Rent</a>
                </nav>

                {{-- Right side --}}
                <div class="flex items-center gap-4">
                    {{-- Cart --}}
                    @php $cartCount = app(\App\Services\CartService::class)->count(); @endphp
                    <a href="{{ route('cart') }}" class="relative text-ivory-300 hover:text-gold-400 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-gold-500 text-ebony-900 text-xs font-ui font-bold rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>

                    {{-- Auth --}}
                    @auth
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('portal.dashboard') }}" class="text-sm font-ui font-medium text-ivory-300 hover:text-gold-400 transition">
                            {{ auth()->user()->role === 'admin' ? 'Admin' : 'My Account' }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-ui font-medium text-ivory-300 hover:text-gold-400 transition">Sign In</a>
                    @endauth

                    {{-- Mobile menu toggle --}}
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden text-ivory-300 hover:text-gold-400 transition">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenu" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden bg-ebony-900 border-t border-ebony-700/50">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('catalog') }}" class="block px-4 py-2.5 rounded-lg text-sm font-ui font-medium text-ivory-300 hover:bg-ebony-700/60 hover:text-gold-400 transition">All Pianos</a>
                <a href="{{ route('catalog.sale') }}" class="block px-4 py-2.5 rounded-lg text-sm font-ui font-medium text-ivory-300 hover:bg-ebony-700/60 hover:text-gold-400 transition">Buy a Piano</a>
                <a href="{{ route('catalog.rent') }}" class="block px-4 py-2.5 rounded-lg text-sm font-ui font-medium text-ivory-300 hover:bg-ebony-700/60 hover:text-gold-400 transition">Rent a Piano</a>
            </div>
        </div>
    </header>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 text-green-800 text-sm font-ui">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 text-red-800 text-sm font-ui">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-ebony-900 border-t border-ebony-700/50 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-gold-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-ebony-900" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 16H7V5h2v10h2V5h2v10h2V5h2v14z"/></svg>
                        </div>
                        <span class="font-display text-lg font-semibold text-ivory-100">PianoHaus</span>
                    </div>
                    <p class="text-sm text-ivory-600 leading-relaxed">{{ config('pianohaus.company.tagline') }}</p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h3 class="text-sm font-ui font-semibold text-ivory-300 uppercase tracking-wider mb-4">Browse</h3>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('catalog') }}" class="text-sm text-ivory-600 hover:text-gold-400 transition">All Pianos</a></li>
                        <li><a href="{{ route('catalog.sale') }}" class="text-sm text-ivory-600 hover:text-gold-400 transition">Pianos for Sale</a></li>
                        <li><a href="{{ route('catalog.rent') }}" class="text-sm text-ivory-600 hover:text-gold-400 transition">Pianos for Rent</a></li>
                    </ul>
                </div>

                {{-- Company --}}
                <div>
                    <h3 class="text-sm font-ui font-semibold text-ivory-300 uppercase tracking-wider mb-4">Company</h3>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('login') }}" class="text-sm text-ivory-600 hover:text-gold-400 transition">Sign In</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h3 class="text-sm font-ui font-semibold text-ivory-300 uppercase tracking-wider mb-4">Contact</h3>
                    <ul class="space-y-2.5">
                        <li class="text-sm text-ivory-600">{{ config('pianohaus.company.phone') }}</li>
                        <li class="text-sm text-ivory-600">{{ config('pianohaus.company.email') }}</li>
                        <li class="text-sm text-ivory-600">{{ config('pianohaus.company.address') }}</li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 pt-8 border-t border-ebony-700/50 text-center">
                <p class="text-xs text-ivory-700 font-ui">&copy; {{ date('Y') }} {{ config('pianohaus.company.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    @stack('scripts')
</body>
</html>
