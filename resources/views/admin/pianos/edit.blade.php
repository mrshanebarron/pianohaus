<x-layouts.admin title="Edit {{ $piano->name }}">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.pianos.show', $piano) }}" class="text-ebony-400 hover:text-ivory-300 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </a>
        <h2 class="text-xl font-display font-semibold text-ivory-100">Edit Piano</h2>
    </div>

    <form method="POST" action="{{ route('admin.pianos.update', $piano) }}">
        @csrf @method('PUT')
        @include('admin.pianos._form', ['piano' => $piano])
    </form>
</x-layouts.admin>
