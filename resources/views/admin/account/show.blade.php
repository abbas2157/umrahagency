@extends('layouts.admin')

@section('title', 'My Account')

@section('content')
<div class="max-w-3xl space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">My Account</h2>
        <p class="text-sm text-gray-500">{{ $user->name }} &middot; {{ $user->email }} &middot; {{ str($user->role)->headline() }}</p>
    </div>

    @if ($errors->any())
        <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-sm font-semibold text-gray-900">Profile</h3>
        <form method="POST" action="{{ route('admin.account.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <x-password-input name="password" label="New Password" :required="false" placeholder="Leave blank to keep current" />
                <x-password-input name="password_confirmation" label="Confirm New Password" :required="false" />
                <div class="sm:col-span-2">
                    <x-password-input name="current_password" label="Current Password (required to save any change)" />
                </div>
            </div>
            <div class="pt-2">
                <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Save Changes</button>
            </div>
        </form>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-900">Last Login</h3>
        @if ($user->last_login_at)
            <p class="mt-1 text-sm text-gray-600">
                {{ $user->last_login_at->format('d M Y, h:i A') }}
                @if ($user->last_login_ip)
                    from <span class="font-medium text-gray-900">{{ $user->last_login_ip }}</span>
                @endif
            </p>
        @else
            <p class="mt-1 text-sm text-gray-400">No login recorded yet.</p>
        @endif
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Active Sessions</h3>
                <p class="text-xs text-gray-500">Every device currently logged in as you.</p>
            </div>
            @if ($sessions->filter(fn ($s) => ! $s['is_current'])->isNotEmpty())
                <form method="POST" action="{{ route('admin.account.sessions.revoke-others') }}" onsubmit="return confirm('Log out every other device?');">
                    @csrf
                    <button class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">Log out all other devices</button>
                </form>
            @endif
        </div>

        <ul class="divide-y divide-gray-100">
            @foreach ($sessions as $session)
                <li class="flex items-center justify-between gap-4 px-6 py-4">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900">
                            {{ $session['device'] }}
                            @if ($session['is_current'])
                                <span class="ml-1 rounded-full bg-green-50 px-2 py-0.5 text-xs font-medium text-green-700">This device</span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">{{ $session['ip_address'] ?? 'Unknown IP' }} &middot; active {{ $session['last_active']->diffForHumans() }}</p>
                    </div>
                    @unless ($session['is_current'])
                        <form method="POST" action="{{ route('admin.account.sessions.revoke', $session['id']) }}" onsubmit="return confirm('Log out this device?');">
                            @csrf
                            @method('DELETE')
                            <button class="whitespace-nowrap rounded-md bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100">Log out</button>
                        </form>
                    @endunless
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
