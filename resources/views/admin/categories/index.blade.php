<x-layouts.admin title="Categories">
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-ebony-400">{{ $categories->count() }} categories</p>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 bg-gold-500 text-ebony-900 font-semibold px-4 py-2 rounded-lg hover:bg-gold-400 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Add Category
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($categories as $category)
            <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-5 hover:border-gold-500/30 transition group">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-display font-semibold text-ivory-100 group-hover:text-gold-400 transition">{{ $category->name }}</h3>
                    <span class="text-xs text-ebony-400">{{ $category->pianos_count }} pianos</span>
                </div>
                <p class="text-sm text-ebony-300 line-clamp-2 mb-3">{{ $category->description }}</p>
                <div class="flex gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-xs text-gold-400 hover:text-gold-300">Edit</a>
                    @if($category->pianos_count === 0)
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-300">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-layouts.admin>
