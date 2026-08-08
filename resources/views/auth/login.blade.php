<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ur' ? 'rtl' : 'ltr' }}" class="h-full">
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
        <div class="mb-4 flex justify-center">
            <x-locale-switcher />
        </div>

        <div class="mb-8 flex flex-col items-center text-center">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Umrah Agency" class="h-16 w-16 rounded-xl bg-white object-contain p-2 shadow-lg">
            <h1 class="mt-4 text-xl font-semibold text-white">{{ __('common.admin_login_heading') }}</h1>
            <p class="mt-1 text-sm text-white/60">{{ __('common.admin_login_subheading') }}</p>
        </div>

        <div class="rounded-2xl bg-white p-8 shadow-xl">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('common.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <x-password-input name="password" :label="__('common.password')" />
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#193670] focus:ring-[#193670]">
                        {{ __('common.remember_me') }}
                    </label>
                    <a href="{{ route('admin.password.request') }}" class="text-sm font-medium text-[#193670] hover:underline">{{ __('common.forgot_password') }}</a>
                </div>
                <button type="submit"
                    class="w-full rounded-lg bg-[#193670] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#122650]">
                    {{ __('common.sign_in') }}
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-white/40">&copy; {{ date('Y') }} Umrah Agency. {{ __('common.all_rights_reserved') }}</p>
    </div>
</div>
</body>
</html>
