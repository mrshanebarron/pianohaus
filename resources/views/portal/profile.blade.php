<x-layouts.storefront :title="'My Profile'">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-2xl font-bold text-ebony-800">My Profile</h1>
                <p class="text-sm font-ui text-ivory-600 mt-1">Update your personal information</p>
            </div>
            <a href="{{ route('portal.dashboard') }}" class="text-sm font-ui text-gold-600 hover:text-gold-500 transition">&larr; Back to Dashboard</a>
        </div>

        @include('portal._nav')

        <div class="max-w-2xl">
            <form method="POST" action="{{ route('portal.profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Personal Info --}}
                <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Personal Information</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $customer->first_name ?? '') }}" class="w-full rounded-lg border border-ivory-400 bg-ivory-50 px-3 py-2.5 text-sm font-ui text-ebony-800 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 transition" required>
                            @error('first_name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name ?? '') }}" class="w-full rounded-lg border border-ivory-400 bg-ivory-50 px-3 py-2.5 text-sm font-ui text-ebony-800 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 transition" required>
                            @error('last_name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full rounded-lg border border-ivory-400 bg-ivory-50 px-3 py-2.5 text-sm font-ui text-ebony-800 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 transition">
                            @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" class="w-full rounded-lg border border-ivory-400 bg-ivory-50 px-3 py-2.5 text-sm font-ui text-ebony-800 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 transition">
                            @error('phone')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Address --}}
                <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Address</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">Address Line 1</label>
                            <input type="text" name="address_line_1" value="{{ old('address_line_1', $customer->address_line_1 ?? '') }}" class="w-full rounded-lg border border-ivory-400 bg-ivory-50 px-3 py-2.5 text-sm font-ui text-ebony-800 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">Address Line 2</label>
                            <input type="text" name="address_line_2" value="{{ old('address_line_2', $customer->address_line_2 ?? '') }}" class="w-full rounded-lg border border-ivory-400 bg-ivory-50 px-3 py-2.5 text-sm font-ui text-ebony-800 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 transition">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">City</label>
                                <input type="text" name="city" value="{{ old('city', $customer->city ?? '') }}" class="w-full rounded-lg border border-ivory-400 bg-ivory-50 px-3 py-2.5 text-sm font-ui text-ebony-800 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">State</label>
                                <input type="text" name="state" value="{{ old('state', $customer->state ?? '') }}" class="w-full rounded-lg border border-ivory-400 bg-ivory-50 px-3 py-2.5 text-sm font-ui text-ebony-800 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-ui font-medium text-ebony-700 mb-1">ZIP Code</label>
                                <input type="text" name="zip" value="{{ old('zip', $customer->zip ?? '') }}" class="w-full rounded-lg border border-ivory-400 bg-ivory-50 px-3 py-2.5 text-sm font-ui text-ebony-800 focus:ring-2 focus:ring-gold-400 focus:border-gold-400 transition">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Account Info --}}
                <div class="bg-white rounded-xl border border-ivory-400/50 p-6">
                    <h2 class="font-display text-lg font-semibold text-ebony-800 mb-4">Account</h2>
                    <div class="text-sm font-ui space-y-2">
                        <div class="flex justify-between">
                            <span class="text-ivory-600">Member Since</span>
                            <span class="text-ebony-800">{{ auth()->user()->created_at->format('F Y') }}</span>
                        </div>
                        @if(isset($customer))
                            <div class="flex justify-between">
                                <span class="text-ivory-600">Total Spent</span>
                                <span class="text-ebony-800 font-medium">{{ $customer->formatted_total_spent }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-gold-500 hover:bg-gold-400 text-ebony-900 font-ui font-semibold px-8 py-3 rounded-lg transition">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

</x-layouts.storefront>
