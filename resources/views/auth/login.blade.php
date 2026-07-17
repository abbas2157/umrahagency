<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login &middot; Umrah Agency</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#193670] font-sans antialiased">
<div class="flex min-h-full items-center justify-center px-4 py-12">
    <div class="w-full max-w-sm">
        <div class="mb-8 flex flex-col items-center text-center">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Umrah Agency" class="h-16 w-16 rounded-xl bg-white object-contain p-2 shadow-lg">
            <h1 class="mt-4 text-xl font-semibold text-white">Umrah Agency Admin</h1>
            <p class="mt-1 text-sm text-white/60">Sign in to manage inquiries</p>
        </div>

        <div class="rounded-2xl bg-white p-8 shadow-xl">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#193670] focus:ring-[#193670]">
                    Remember me
                </label>
                <button type="submit"
                    class="w-full rounded-lg bg-[#193670] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#122650]">
                    Sign in
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-white/40">&copy; {{ date('Y') }} Umrah Agency. All rights reserved.</p>
    </div>
</div>
</body>
</html>
