<x-layouts.admin title="Rentals">
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-ebony-400">{{ $rentals->total() }} rentals</p>
        <form method="GET" class="flex gap-3">
            <select name="status" onchange="this.form.submit()" class="bg-ebony-700/40 border border-ebony-600/30 rounded-lg px-3 py-2 text-sm text-ivory-300 focus:border-gold-500 focus:outline-none">
                <option value="">All Statuses</option>
                @foreach(['pending_application', 'approved', 'active', 'past_due', 'completed', 'cancelled', 'denied'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-ebony-600/30">
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Rental</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Customer</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Piano</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Monthly</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Status</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Start</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebony-600/20">
                @forelse($rentals as $rental)
                    <tr class="hover:bg-ebony-700/30 transition cursor-pointer" onclick="window.location='{{ route('admin.rentals.show', $rental) }}'">
                        <td class="px-4 py-3 font-medium text-ivory-100">{{ $rental->rental_number }}</td>
                        <td class="px-4 py-3 text-ivory-300">{{ $rental->customer->full_name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-ebony-300">{{ $rental->piano->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-ivory-100">{{ $rental->formatted_monthly_rate }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $rental->status_color }}-500/20 text-{{ $rental->status_color }}-400">{{ $rental->status_label }}</span>
                        </td>
                        <td class="px-4 py-3 text-right text-ebony-400 text-xs">{{ $rental->start_date?->format('M j, Y') ?? 'Pending' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-ebony-400">No rentals found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $rentals->withQueryString()->links() }}</div>
</x-layouts.admin>
