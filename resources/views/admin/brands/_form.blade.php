@php $brand = $brand ?? null; @endphp

<div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6 space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-ivory-300 mb-1">Brand Name *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $brand?->name) }}" required
               class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
        @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="description" class="block text-sm font-medium text-ivory-300 mb-1">Description</label>
        <textarea name="description" id="description" rows="4"
                  class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">{{ old('description', $brand?->description) }}</textarea>
    </div>
    <div class="flex gap-3">
        <button type="submit" class="bg-gold-500 text-ebony-900 font-semibold px-6 py-2 rounded-lg hover:bg-gold-400 transition text-sm">
            {{ $brand ? 'Update' : 'Create' }} Brand
        </button>
        <a href="{{ route('admin.brands.index') }}" class="bg-ebony-600/50 text-ivory-300 px-4 py-2 rounded-lg text-sm hover:bg-ebony-600 transition">Cancel</a>
    </div>
</div>
