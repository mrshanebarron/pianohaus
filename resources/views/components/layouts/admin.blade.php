<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} — PianoHaus Admin</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Source+Serif+4:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link { display: flex; align-items: center; gap: 0.75rem; padding: 0.625rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; transition: all 0.2s; }
        .sidebar-link:hover { background-color: rgba(31, 31, 57, 0.6); color: #d8d8e2; }
        .sidebar-link.active { background-color: rgba(201, 169, 89, 0.2); color: #d9ab42; border-left: 2px solid #c9a959; }
        .stat-card { background-color: rgba(31, 31, 57, 0.4); border: 1px solid rgba(45, 45, 83, 0.3); border-radius: 0.75rem; padding: 1.25rem; backdrop-filter: blur(4px); }
    </style>
    @livewireStyles
</head>
<body class="h-full bg-ebony-800 font-ui text-ivory-300 antialiased">
    <div x-data="{ sidebarOpen: true, mobileSidebar: false }" class="flex h-full">

        {{-- Sidebar --}}
        <aside
            :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="hidden lg:flex flex-col bg-ebony-900 border-r border-ebony-700/50 transition-all duration-300 flex-shrink-0"
        >
            {{-- Logo --}}
            <div class="flex items-center gap-3 px-5 py-5 border-b border-ebony-700/50">
                <div class="w-9 h-9 bg-gold-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-ebony-900" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 16H7V5h2v10h2V5h2v10h2V5h2v14z"/></svg>
                </div>
                <span x-show="sidebarOpen" x-transition class="font-display text-lg font-semibold text-ivory-100 tracking-wide">PianoHaus</span>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Dashboard</span>
                </a>

                <div x-show="sidebarOpen" class="pt-4 pb-1 px-4"><span class="text-xs font-semibold uppercase tracking-wider text-ebony-400">Inventory</span></div>

                <a href="{{ route('admin.pianos.index') }}" class="sidebar-link {{ request()->routeIs('admin.pianos.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Pianos</span>
                </a>
                <a href="{{ route('admin.brands.index') }}" class="sidebar-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Brands</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Categories</span>
                </a>

                <div x-show="sidebarOpen" class="pt-4 pb-1 px-4"><span class="text-xs font-semibold uppercase tracking-wider text-ebony-400">Sales & Rentals</span></div>

                <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Orders</span>
                </a>
                <a href="{{ route('admin.rentals.index') }}" class="sidebar-link {{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Rentals</span>
                </a>
                <a href="{{ route('admin.customers.index') }}" class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Customers</span>
                </a>

                <div x-show="sidebarOpen" class="pt-4 pb-1 px-4"><span class="text-xs font-semibold uppercase tracking-wider text-ebony-400">Documents</span></div>

                <a href="{{ route('admin.invoices.index') }}" class="sidebar-link {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Invoices</span>
                </a>
                <a href="{{ route('admin.contracts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contracts.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9"/></svg>
                    <span x-show="sidebarOpen" x-transition>Contracts</span>
                </a>

                <div x-show="sidebarOpen" class="pt-4 pb-1 px-4"><span class="text-xs font-semibold uppercase tracking-wider text-ebony-400">Engagement</span></div>

                <a href="{{ route('admin.reviews.index') }}" class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Reviews</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Reports</span>
                </a>
            </nav>

            {{-- Sidebar footer --}}
            <div class="px-4 py-4 border-t border-ebony-700/50">
                <a href="{{ route('home') }}" class="sidebar-link text-ebony-400 hover:text-ivory-300">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    <span x-show="sidebarOpen" x-transition>View Store</span>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="sidebar-link text-ebony-400 hover:text-ivory-300 w-full mt-1">
                    <svg x-show="sidebarOpen" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5"/></svg>
                    <svg x-show="!sidebarOpen" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5"/></svg>
                    <span x-show="sidebarOpen" x-transition>Collapse</span>
                </button>
            </div>
        </aside>

        {{-- Mobile sidebar overlay --}}
        <div x-show="mobileSidebar" x-transition.opacity class="lg:hidden fixed inset-0 bg-black/60 z-40" @click="mobileSidebar = false"></div>
        <aside x-show="mobileSidebar" x-transition:enter="transform transition-transform duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition-transform duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="lg:hidden fixed inset-y-0 left-0 w-64 bg-ebony-900 z-50 flex flex-col" x-cloak>
            <div class="flex items-center justify-between px-5 py-5 border-b border-ebony-700/50">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gold-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-ebony-900" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 16H7V5h2v10h2V5h2v10h2V5h2v14z"/></svg>
                    </div>
                    <span class="font-display text-lg font-semibold text-ivory-100">PianoHaus</span>
                </div>
                <button @click="mobileSidebar = false" class="text-ebony-400 hover:text-ivory-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            {{-- Same nav links for mobile — simplified --}}
            <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
                @foreach([
                    ['admin.dashboard', 'Dashboard'],
                    ['admin.pianos.index', 'Pianos'],
                    ['admin.brands.index', 'Brands'],
                    ['admin.categories.index', 'Categories'],
                    ['admin.orders.index', 'Orders'],
                    ['admin.rentals.index', 'Rentals'],
                    ['admin.customers.index', 'Customers'],
                    ['admin.invoices.index', 'Invoices'],
                    ['admin.contracts.index', 'Contracts'],
                    ['admin.reviews.index', 'Reviews'],
                    ['admin.reports', 'Reports'],
                ] as [$routeName, $label])
                    <a href="{{ route($routeName) }}" @click="mobileSidebar = false"
                       class="sidebar-link {{ request()->routeIs($routeName . '*') || request()->routeIs($routeName) ? 'active' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top bar --}}
            <header class="flex items-center justify-between px-6 py-4 bg-ebony-900/50 border-b border-ebony-700/30">
                <div class="flex items-center gap-4">
                    <button @click="mobileSidebar = true" class="lg:hidden text-ebony-400 hover:text-ivory-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                    </button>
                    <h1 class="text-xl font-display font-semibold text-ivory-100">{{ $title ?? 'Dashboard' }}</h1>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-ebony-400">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-ebony-400 hover:text-ivory-300 transition">Logout</button>
                    </form>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto p-6">
                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="mb-6 bg-green-900/30 border border-green-700/50 rounded-lg px-4 py-3 text-green-300 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 bg-red-900/30 border border-red-700/50 rounded-lg px-4 py-3 text-red-300 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
