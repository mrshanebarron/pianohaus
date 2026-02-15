<x-layouts.admin title="Pianos">

    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm text-ebony-400">{{ $pianos->total() }} pianos in inventory</p>
        </div>
        <a href="{{ route('admin.pianos.create') }}" class="inline-flex items-center gap-2 bg-gold-500 text-ebony-900 font-semibold px-4 py-2 rounded-lg hover:bg-gold-400 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Add Piano
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search pianos..."
               class="bg-ebony-700/40 border border-ebony-600/30 rounded-lg px-4 py-2 text-sm text-ivory-100 placeholder-ebony-400 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none w-64">

        <select name="status" class="bg-ebony-700/40 border border-ebony-600/30 rounded-lg px-3 py-2 text-sm text-ivory-300 focus:border-gold-500 focus:outline-none">
            <option value="">All Statuses</option>
            @foreach(['available', 'reserved', 'sold', 'rented', 'maintenance', 'retired'] as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
            @endforeach
        </select>

        <select name="type" class="bg-ebony-700/40 border border-ebony-600/30 rounded-lg px-3 py-2 text-sm text-ivory-300 focus:border-gold-500 focus:outline-none">
            <option value="">All Types</option>
            @foreach(['sale', 'rental', 'both'] as $type)
                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
            @endforeach
        </select>

        <select name="brand" class="bg-ebony-700/40 border border-ebony-600/30 rounded-lg px-3 py-2 text-sm text-ivory-300 focus:border-gold-500 focus:outline-none">
            <option value="">All Brands</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-ebony-600/50 text-ivory-300 px-4 py-2 rounded-lg text-sm hover:bg-ebony-600 transition">Filter</button>
        @if(request()->anyFilled(['search', 'status', 'type', 'brand', 'category']))
            <a href="{{ route('admin.pianos.index') }}" class="text-sm text-ebony-400 hover:text-ivory-300 py-2 px-2">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-ebony-600/30">
                        <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Piano</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Brand</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Category</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Type</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Price</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400">Status</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold uppercase tracking-wider text-ebony-400"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ebony-600/20">
                    @forelse($pianos as $piano)
                        <tr class="hover:bg-ebony-700/30 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-ebony-600/50 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                        @if($piano->primaryPhoto)
                                            <img src="{{ asset('storage/' . $piano->primaryPhoto->path) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-5 h-5 text-ebony-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a2.25 2.25 0 002.25-2.25V5.25a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.pianos.show', $piano) }}" class="font-medium text-ivory-100 hover:text-gold-400 transition">{{ $piano->name }}</a>
                                        <div class="text-xs text-ebony-400">{{ $piano->year }} &middot; {{ $piano->condition_label }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-ivory-300">{{ $piano->brand->name }}</td>
                            <td class="px-4 py-3 text-ivory-300">{{ $piano->category->name }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-medium
                                    {{ $piano->type === 'both' ? 'bg-purple-500/20 text-purple-400' : ($piano->type === 'rental' ? 'bg-blue-500/20 text-blue-400' : 'bg-green-500/20 text-green-400') }}">
                                    {{ ucfirst($piano->type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right text-ivory-100 font-medium">
                                {{ $piano->formatted_sale_price }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $piano->status === 'available' ? 'green' : ($piano->status === 'sold' ? 'gray' : ($piano->status === 'rented' ? 'indigo' : 'yellow')) }}-500/20 text-{{ $piano->status === 'available' ? 'green' : ($piano->status === 'sold' ? 'gray' : ($piano->status === 'rented' ? 'indigo' : 'yellow')) }}-400">
                                    {{ ucfirst($piano->status) }}
                                </span>
                                @if($piano->is_featured)
                                    <span class="inline-block ml-1 px-1.5 py-0.5 rounded text-xs bg-gold-500/20 text-gold-400">Featured</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.pianos.edit', $piano) }}" class="text-ebony-400 hover:text-gold-400 transition">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-ebony-400">No pianos found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $pianos->withQueryString()->links() }}
    </div>

</x-layouts.admin>
