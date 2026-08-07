<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ur' ? 'rtl' : 'ltr' }}" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('common.dashboard')) &middot; Umrah Agency</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900">
<div class="min-h-full">

    <div id="sidebar-backdrop" class="fixed inset-0 z-40 hidden bg-gray-900/50 lg:hidden"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 flex w-64 -translate-x-full transform flex-col bg-[#193670] transition-transform duration-200 ease-in-out rtl:left-auto rtl:right-0 rtl:translate-x-full lg:translate-x-0 rtl:lg:translate-x-0">
        <div class="flex h-16 items-center gap-3 border-b border-white/10 px-6">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Umrah Agency" class="h-9 w-9 rounded bg-white object-contain p-1">
            <div class="leading-tight">
                <p class="text-sm font-semibold text-white">Umrah Agency</p>
                <p class="text-xs text-white/50">{{ __('common.agency_panel') }}</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
            <p class="admin-nav-heading">{{ __('common.overview') }}</p>
            <a href="{{ route('agency.dashboard') }}" class="admin-nav-link {{ request()->routeIs('agency.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V9.5Z"/></svg>
                {{ __('common.dashboard') }}
            </a>

            <p class="admin-nav-heading">{{ __('common.queries') }}</p>
            <a href="{{ route('agency.inquiries.index') }}" class="admin-nav-link {{ request()->routeIs('agency.inquiries.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v12H7l-3 3V4Z"/><path d="M8 9h8M8 12h5"/></svg>
                {{ __('common.queries') }}
            </a>

            @if (auth()->user()?->isAgencyAdmin())
                <p class="admin-nav-heading">{{ __('common.my_agency') }}</p>
                <a href="{{ route('agency.agency-profile.edit') }}" class="admin-nav-link {{ request()->routeIs('agency.agency-profile.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
                    {{ __('common.agency_profile') }}
                </a>
                <a href="{{ route('agency.agents.index') }}" class="admin-nav-link {{ request()->routeIs('agency.agents.*') && ! request()->routeIs('agency.agents.performance') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    {{ __('common.my_agents') }}
                </a>
                <a href="{{ route('agency.branches.index') }}" class="admin-nav-link {{ request()->routeIs('agency.branches.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V9l7-6 7 6v12"/><path d="M9 21v-6h6v6"/><path d="M9 12h.01M15 12h.01M9 8h.01M15 8h.01"/></svg>
                    {{ __('common.branches') }}
                </a>
                <a href="{{ route('agency.billing.index') }}" class="admin-nav-link {{ request()->routeIs('agency.billing.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                    {{ __('common.billing') }}
                </a>

                <p class="admin-nav-heading">{{ __('common.monitoring') }}</p>
                <a href="{{ route('agency.agents.performance') }}" class="admin-nav-link {{ request()->routeIs('agency.agents.performance') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M18 17V9M13 17V5M8 17v-3"/></svg>
                    {{ __('common.agent_performance') }}
                </a>
                <a href="{{ route('agency.activity-log.index') }}" class="admin-nav-link {{ request()->routeIs('agency.activity-log.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="9"/></svg>
                    {{ __('common.activity_log') }}
                </a>
            @endif
        </nav>

        <div class="border-t border-white/10 p-4">
            <a href="{{ route('account.show') }}" class="mb-3 flex items-center gap-3 rounded-lg p-1 transition hover:bg-white/10">
                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-white/10 font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                    <p class="truncate text-xs text-white/50">{{ auth()->user()->email }}</p>
                </div>
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-white/10 px-3 py-2 text-sm font-medium text-white transition hover:bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/></svg>
                    {{ __('common.logout') }}
                </button>
            </form>
        </div>
    </aside>

    <div class="lg:pl-64 rtl:lg:pl-0 rtl:lg:pr-64">
        <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-gray-200 bg-white px-4 lg:px-8">
            <div class="flex items-center gap-4">
                <button id="sidebar-toggle" type="button" class="text-gray-500 hover:text-gray-700 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-900">@yield('title', __('common.dashboard'))</h1>
            </div>
            <x-locale-switcher />
        </header>

        <main class="px-4 py-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    (function () {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        const toggle = document.getElementById('sidebar-toggle');
        // RTL's "closed" position is off the right edge, not the left —
        // the two directions use different Tailwind classes, not just a
        // mirrored value of the same one.
        const closedClass = document.documentElement.dir === 'rtl' ? 'translate-x-full' : '-translate-x-full';

        function openSidebar() {
            sidebar.classList.remove(closedClass);
            backdrop.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add(closedClass);
            backdrop.classList.add('hidden');
        }

        toggle?.addEventListener('click', openSidebar);
        backdrop?.addEventListener('click', closeSidebar);
    })();
</script>
</body>
</html>
