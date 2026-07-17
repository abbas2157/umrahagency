<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') &middot; Umrah Agency Admin</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900">
<div class="min-h-full">

    <div id="sidebar-backdrop" class="fixed inset-0 z-40 hidden bg-gray-900/50 lg:hidden"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 flex w-64 -translate-x-full transform flex-col bg-[#193670] transition-transform duration-200 ease-in-out lg:translate-x-0">
        <div class="flex h-16 items-center gap-3 border-b border-white/10 px-6">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Umrah Agency" class="h-9 w-9 rounded bg-white object-contain p-1">
            <div class="leading-tight">
                <p class="text-sm font-semibold text-white">Umrah Agency</p>
                <p class="text-xs text-white/50">Admin Panel</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V9.5Z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.inquiries.index') }}" class="admin-nav-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v12H7l-3 3V4Z"/><path d="M8 9h8M8 12h5"/></svg>
                Inquiries
            </a>
            <a href="{{ route('admin.contact-clicks.index') }}" class="admin-nav-link {{ request()->routeIs('admin.contact-clicks.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
                Contact Clicks
            </a>
        </nav>

        <div class="border-t border-white/10 p-4">
            <div class="mb-3 flex items-center gap-3">
                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-white/10 font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                    <p class="truncate text-xs text-white/50">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-white/10 px-3 py-2 text-sm font-medium text-white transition hover:bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="lg:pl-64">
        <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-gray-200 bg-white px-4 lg:px-8">
            <button id="sidebar-toggle" type="button" class="text-gray-500 hover:text-gray-700 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <h1 class="text-lg font-semibold text-gray-900">@yield('title', 'Dashboard')</h1>
        </header>

        <main class="px-4 py-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
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

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }

        toggle?.addEventListener('click', openSidebar);
        backdrop?.addEventListener('click', closeSidebar);
    })();
</script>
</body>
</html>
