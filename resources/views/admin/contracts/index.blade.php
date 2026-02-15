<x-layouts.admin title="Contracts">
    <div class="mb-6">
        <p class="text-sm text-ebony-400">{{ $contracts->total() }} contracts</p>
    </div>

    <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-ebony-600/30">
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Contract</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Customer</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Piano</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Type</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Status</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Signed</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebony-600/20">
                @forelse($contracts as $contract)
                    <tr class="hover:bg-ebony-700/30 transition cursor-pointer" onclick="window.location='{{ route('admin.contracts.show', $contract) }}'">
                        <td class="px-4 py-3 font-medium text-ivory-100">{{ $contract->contract_number }}</td>
                        <td class="px-4 py-3 text-ivory-300">{{ $contract->customer->full_name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-ebony-300">{{ $contract->rental->piano->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-ebony-300">{{ ucfirst(str_replace('_', ' ', $contract->type)) }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $contract->status_color }}-500/20 text-{{ $contract->status_color }}-400">{{ $contract->status_label }}</span>
                        </td>
                        <td class="px-4 py-3 text-right text-ebony-400 text-xs">{{ $contract->customer_signed_at?->format('M j, Y') ?? 'Not signed' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-ebony-400">No contracts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $contracts->withQueryString()->links() }}</div>
</x-layouts.admin>
