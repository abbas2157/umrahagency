<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password &middot; Umrah Agency Admin</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#193670] font-sans antialiased">
<div class="flex min-h-full items-center justify-center px-4 py-12">
    <div class="w-full max-w-sm">
        <div class="mb-8 flex flex-col items-center text-center">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Umrah Agency" class="h-16 w-16 rounded-xl bg-white object-contain p-2 shadow-lg">
            <h1 class="mt-4 text-xl font-semibold text-white">Reset your password</h1>
        </div>

        <div class="rounded-2xl bg-white p-8 shadow-xl">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required autofocus
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <x-password-input name="password" label="New Password" />
                <x-password-input name="password_confirmation" label="Confirm New Password" />
                <button type="submit"
                    class="w-full rounded-lg bg-[#193670] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#122650]">
                    Reset Password
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-white/40">&copy; {{ date('Y') }} Umrah Agency. All rights reserved.</p>
    </div>
</div>
</body>
</html>
