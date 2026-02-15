@php $piano = $piano ?? null; @endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        {{-- Basic Info --}}
        <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6 space-y-4">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400">Basic Information</h3>

            <div>
                <label for="name" class="block text-sm font-medium text-ivory-300 mb-1">Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $piano?->name) }}" required
                       class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">
                @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="brand_id" class="block text-sm font-medium text-ivory-300 mb-1">Brand *</label>
                    <select name="brand_id" id="brand_id" required class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
                        <option value="">Select brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $piano?->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="category_id" class="block text-sm font-medium text-ivory-300 mb-1">Category *</label>
                    <select name="category_id" id="category_id" required class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $piano?->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="short_description" class="block text-sm font-medium text-ivory-300 mb-1">Short Description</label>
                <input type="text" name="short_description" id="short_description" value="{{ old('short_description', $piano?->short_description) }}"
                       class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none"
                       maxlength="255" placeholder="Brief one-liner for cards and listings">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-ivory-300 mb-1">Full Description *</label>
                <textarea name="description" id="description" rows="8" required
                          class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none">{{ old('description', $piano?->description) }}</textarea>
            </div>
        </div>

        {{-- Specs --}}
        <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6 space-y-4">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400">Specifications</h3>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="year" class="block text-sm font-medium text-ivory-300 mb-1">Year</label>
                    <input type="number" name="year" id="year" value="{{ old('year', $piano?->year) }}" min="1800" max="{{ date('Y') + 1 }}"
                           class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
                </div>
                <div>
                    <label for="condition" class="block text-sm font-medium text-ivory-300 mb-1">Condition *</label>
                    <select name="condition" id="condition" required class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
                        @foreach(['excellent' => 'Excellent', 'very_good' => 'Very Good', 'good' => 'Good', 'fair' => 'Fair', 'needs_restoration' => 'Needs Restoration'] as $val => $label)
                            <option value="{{ $val }}" {{ old('condition', $piano?->condition) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="finish" class="block text-sm font-medium text-ivory-300 mb-1">Finish</label>
                    <input type="text" name="finish" id="finish" value="{{ old('finish', $piano?->finish) }}"
                           class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="serial_number" class="block text-sm font-medium text-ivory-300 mb-1">Serial Number</label>
                    <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $piano?->serial_number) }}"
                           class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-ivory-300 mb-1">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $piano?->location) }}"
                           class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Pricing --}}
        <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6 space-y-4">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400">Pricing</h3>

            <div>
                <label for="type" class="block text-sm font-medium text-ivory-300 mb-1">Listing Type *</label>
                <select name="type" id="type" required class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
                    @foreach(['sale' => 'For Sale', 'rental' => 'For Rent', 'both' => 'Sale & Rent'] as $val => $label)
                        <option value="{{ $val }}" {{ old('type', $piano?->type) == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="sale_price" class="block text-sm font-medium text-ivory-300 mb-1">Sale Price ($)</label>
                <input type="number" name="sale_price" id="sale_price" step="0.01" min="0"
                       value="{{ old('sale_price', $piano ? $piano->sale_price / 100 : '') }}"
                       class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
            </div>

            <div>
                <label for="original_price" class="block text-sm font-medium text-ivory-300 mb-1">Original Price ($)</label>
                <input type="number" name="original_price" id="original_price" step="0.01" min="0"
                       value="{{ old('original_price', $piano && $piano->original_price ? $piano->original_price / 100 : '') }}"
                       class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
            </div>

            <div>
                <label for="rental_price_monthly" class="block text-sm font-medium text-ivory-300 mb-1">Monthly Rental ($)</label>
                <input type="number" name="rental_price_monthly" id="rental_price_monthly" step="0.01" min="0"
                       value="{{ old('rental_price_monthly', $piano && $piano->rental_price_monthly ? $piano->rental_price_monthly / 100 : '') }}"
                       class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
            </div>

            <div>
                <label for="rental_deposit" class="block text-sm font-medium text-ivory-300 mb-1">Rental Deposit ($)</label>
                <input type="number" name="rental_deposit" id="rental_deposit" step="0.01" min="0"
                       value="{{ old('rental_deposit', $piano && $piano->rental_deposit ? $piano->rental_deposit / 100 : '') }}"
                       class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
            </div>

            <div>
                <label for="rental_minimum_months" class="block text-sm font-medium text-ivory-300 mb-1">Min. Rental (months)</label>
                <input type="number" name="rental_minimum_months" id="rental_minimum_months" min="1"
                       value="{{ old('rental_minimum_months', $piano?->rental_minimum_months ?? 3) }}"
                       class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
            </div>
        </div>

        {{-- Status & Flags --}}
        <div class="bg-ebony-700/40 border border-ebony-600/30 rounded-xl p-6 space-y-4">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-ebony-400">Status</h3>

            <div>
                <label for="status" class="block text-sm font-medium text-ivory-300 mb-1">Status *</label>
                <select name="status" id="status" required class="w-full bg-ebony-800 border border-ebony-600/50 rounded-lg px-4 py-2 text-sm text-ivory-100 focus:border-gold-500 focus:outline-none">
                    @foreach(['available', 'reserved', 'sold', 'rented', 'maintenance', 'retired'] as $status)
                        <option value="{{ $status }}" {{ old('status', $piano?->status ?? 'available') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $piano?->is_featured) ? 'checked' : '' }}
                       class="rounded border-ebony-600 bg-ebony-800 text-gold-500 focus:ring-gold-500">
                <span class="text-sm text-ivory-300">Featured Piano</span>
            </label>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="hidden" name="is_certified" value="0">
                <input type="checkbox" name="is_certified" value="1" {{ old('is_certified', $piano?->is_certified) ? 'checked' : '' }}
                       class="rounded border-ebony-600 bg-ebony-800 text-gold-500 focus:ring-gold-500">
                <span class="text-sm text-ivory-300">Certified Pre-Owned</span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3">
            <button type="submit" class="flex-1 bg-gold-500 text-ebony-900 font-semibold py-2.5 rounded-lg hover:bg-gold-400 transition text-sm">
                {{ $piano ? 'Update Piano' : 'Create Piano' }}
            </button>
            <a href="{{ $piano ? route('admin.pianos.show', $piano) : route('admin.pianos.index') }}"
               class="bg-ebony-600/50 text-ivory-300 px-4 py-2.5 rounded-lg text-sm hover:bg-ebony-600 transition">Cancel</a>
        </div>
    </div>
</div>
