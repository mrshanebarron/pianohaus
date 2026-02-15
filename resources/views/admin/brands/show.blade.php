<x-layouts.admin title="{{ $brand->name }}">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.brands.index') }}" class="text-ebony-400 hover:text-ivory-300 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </a>
        <h2 class="text-xl font-display font-semibold text-ivory-100">{{ $brand->name }}</h2>
        <a href="{{ route('admin.brands.edit', $brand) }}" class="text-xs text-gold-400 hover:text-gold-300">Edit</a>
    </div>
    <p class="text-sm text-ivory-300 mb-6">{{ $brand->description }}</p>
    <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400 mb-3">Pianos ({{ $brand->pianos->count() }})</h3>
    <div class="space-y-2">
        @foreach($brand->pianos as $piano)
            <a href="{{ route('admin.pianos.show', $piano) }}" class="flex items-center justify-between p-3 bg-ebony-700/40 border border-ebony-600/30 rounded-lg hover:border-gold-500/30 transition">
                <span class="text-sm text-ivory-100">{{ $piano->name }}</span>
                <span class="text-xs text-ebony-400">{{ ucfirst($piano->status) }}</span>
            </a>
        @endforeach
    </div>
</x-layouts.admin>
