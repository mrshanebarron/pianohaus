<x-layouts.admin title="Edit {{ $category->name }}">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-ebony-400 hover:text-ivory-300 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </a>
        <h2 class="text-xl font-display font-semibold text-ivory-100">Edit Category</h2>
    </div>
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="max-w-lg bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6 space-y-4">
        @csrf @method('PUT')
        <div>
            <label for="name" class="block text-sm font-medium text-ivory-300 mb-1">Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
            @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-ivory-300 mb-1">Description</label>
            <textarea name="description" id="description" rows="3" class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">{{ old('description', $category->description) }}</textarea>
        </div>
        <div>
            <label for="icon" class="block text-sm font-medium text-ivory-300 mb-1">Icon Key</label>
            <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}" class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-gold-500 text-ebony-900 font-semibold px-6 py-2 rounded-lg hover:bg-gold-400 transition text-sm">Update Category</button>
            <a href="{{ route('admin.categories.index') }}" class="bg-ebony-600/50 text-ivory-300 px-4 py-2 rounded-lg text-sm hover:bg-ebony-600 transition">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
