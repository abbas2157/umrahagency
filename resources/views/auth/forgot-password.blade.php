<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password &middot; Umrah Agency Admin</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#193670] font-sans antialiased">
<div class="flex min-h-full items-center justify-center px-4 py-12">
    <div class="w-full max-w-sm">
        <div class="mb-8 flex flex-col items-center text-center">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Umrah Agency" class="h-16 w-16 rounded-xl bg-white object-contain p-2 shadow-lg">
            <h1 class="mt-4 text-xl font-semibold text-white">Forgot your password?</h1>
            <p class="mt-1 text-sm text-white/60">We'll email you a link to reset it.</p>
        </div>

        <div class="rounded-2xl bg-white p-8 shadow-xl">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <button type="submit"
                    class="w-full rounded-lg bg-[#193670] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#122650]">
                    Send Reset Link
                </button>
            </form>

            <a href="{{ route('admin.login') }}" class="mt-4 block text-center text-sm font-medium text-[#193670] hover:underline">&larr; Back to login</a>
        </div>

        <p class="mt-6 text-center text-xs text-white/40">&copy; {{ date('Y') }} Umrah Agency. All rights reserved.</p>
    </div>
</div>
</body>
</html>
