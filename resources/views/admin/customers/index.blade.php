<x-layouts.admin title="Customers">
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-ebony-400">{{ $customers->total() }} customers</p>
        <form method="GET">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customers..."
                   class="bg-ebony-700/40 border border-ebony-600/30 rounded-lg px-4 py-2 text-sm text-ivory-100 placeholder-ebony-400 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none w-64">
        </form>
    </div>

    <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-ebony-600/30">
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Customer</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Email</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Phone</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Orders</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Rentals</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebony-600/20">
                @forelse($customers as $customer)
                    <tr class="hover:bg-ebony-700/30 transition cursor-pointer" onclick="window.location='{{ route('admin.customers.show', $customer) }}'">
                        <td class="px-4 py-3 font-medium text-ivory-100">{{ $customer->full_name }}</td>
                        <td class="px-4 py-3 text-ebony-300">{{ $customer->email }}</td>
                        <td class="px-4 py-3 text-ebony-300">{{ $customer->phone }}</td>
                        <td class="px-4 py-3 text-center text-ivory-300">{{ $customer->orders_count }}</td>
                        <td class="px-4 py-3 text-center text-ivory-300">{{ $customer->rentals_count }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-ebony-400">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $customers->withQueryString()->links() }}</div>
</x-layouts.admin>
