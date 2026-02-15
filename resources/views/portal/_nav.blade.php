<nav class="flex flex-wrap gap-2 mb-8 border-b border-ivory-400/50 pb-4">
    <a href="{{ route('portal.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-ui font-medium {{ request()->routeIs('portal.dashboard') ? 'bg-ebony-800 text-ivory-100' : 'text-ebony-700 hover:bg-ivory-300/50' }} transition">Dashboard</a>
    <a href="{{ route('portal.orders') }}" class="px-4 py-2 rounded-lg text-sm font-ui font-medium {{ request()->routeIs('portal.orders*') ? 'bg-ebony-800 text-ivory-100' : 'text-ebony-700 hover:bg-ivory-300/50' }} transition">Orders</a>
    <a href="{{ route('portal.rentals') }}" class="px-4 py-2 rounded-lg text-sm font-ui font-medium {{ request()->routeIs('portal.rentals*') ? 'bg-ebony-800 text-ivory-100' : 'text-ebony-700 hover:bg-ivory-300/50' }} transition">Rentals</a>
    <a href="{{ route('portal.payments') }}" class="px-4 py-2 rounded-lg text-sm font-ui font-medium {{ request()->routeIs('portal.payments') ? 'bg-ebony-800 text-ivory-100' : 'text-ebony-700 hover:bg-ivory-300/50' }} transition">Payments</a>
    <a href="{{ route('portal.documents') }}" class="px-4 py-2 rounded-lg text-sm font-ui font-medium {{ request()->routeIs('portal.documents') ? 'bg-ebony-800 text-ivory-100' : 'text-ebony-700 hover:bg-ivory-300/50' }} transition">Documents</a>
    <a href="{{ route('portal.profile') }}" class="px-4 py-2 rounded-lg text-sm font-ui font-medium {{ request()->routeIs('portal.profile') ? 'bg-ebony-800 text-ivory-100' : 'text-ebony-700 hover:bg-ivory-300/50' }} transition">Profile</a>
</nav>
