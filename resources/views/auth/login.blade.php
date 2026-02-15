<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — PianoHaus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: {
                ebony: { 800: '#1a1a2e', 900: '#111120' },
                gold: { 400: '#d9ab42', 500: '#c9a959' },
                ivory: { 100: '#fcfaf5', 300: '#f5f0e8' },
            }}}
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="h-full bg-ebony-800 flex items-center justify-center" style="font-family: Inter, sans-serif;">
    <div class="w-full max-w-md px-6">
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-gold-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-ebony-900" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 16H7V5h2v10h2V5h2v10h2V5h2v14z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-ivory-100" style="font-family: Playfair Display, serif;">PianoHaus</h1>
            <p class="text-sm text-gray-400 mt-1">Sign in to continue</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="bg-ebony-900 rounded-2xl border border-gray-700/30 p-8 space-y-5">
            @csrf

            @if($errors->any())
                <div class="bg-red-900/30 border border-red-700/40 rounded-lg px-4 py-3 text-red-300 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="w-full bg-ebony-800 border border-gray-600/50 rounded-lg px-4 py-2.5 text-ivory-100 placeholder-gray-500 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none transition">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full bg-ebony-800 border border-gray-600/50 rounded-lg px-4 py-2.5 text-ivory-100 placeholder-gray-500 focus:border-gold-500 focus:ring-1 focus:ring-gold-500 focus:outline-none transition">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-600 bg-ebony-800 text-gold-500 focus:ring-gold-500">
                    <span class="text-sm text-gray-400">Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-gold-500 text-ebony-900 font-semibold py-2.5 rounded-lg hover:bg-gold-400 transition-colors">
                Sign In
            </button>

            <div class="text-center text-xs text-gray-500 pt-2 border-t border-gray-700/30">
                <p>Demo: admin@pianohaus.com / password</p>
            </div>
        </form>
    </div>
</body>
</html>
