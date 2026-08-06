@extends('layouts.admin')

@section('title', 'Active Sessions')

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">
        &larr; Back to users
    </a>

    <div>
        <h2 class="text-2xl font-bold text-gray-900">Active Sessions</h2>
        <p class="text-sm text-gray-500">{{ $user->name }} ({{ $user->email }})</p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <ul class="divide-y divide-gray-100">
            @forelse ($sessions as $session)
                <li class="flex items-center justify-between gap-4 px-6 py-4">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $session['device'] }}</p>
                        <p class="text-xs text-gray-500">{{ $session['ip_address'] ?? 'Unknown IP' }} &middot; active {{ $session['last_active']->diffForHumans() }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.users.sessions.revoke', [$user, $session['id']]) }}" onsubmit="return confirm('Log out this device?');">
                        @csrf
                        @method('DELETE')
                        <button class="whitespace-nowrap rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">Log out</button>
                    </form>
                </li>
            @empty
                <li class="px-6 py-10 text-center text-sm text-gray-400">No active sessions.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
