@extends('layouts.admin')

@section('title', __('common.active_sessions'))

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">
        &larr; {{ __('common.back_to_users') }}
    </a>

    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ __('common.active_sessions') }}</h2>
        <p class="text-sm text-gray-500">{{ $user->name }} ({{ $user->email }})</p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <ul class="divide-y divide-gray-100">
            @forelse ($sessions as $session)
                <li class="flex items-center justify-between gap-4 px-6 py-4">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $session['device'] }}</p>
                        <p class="text-xs text-gray-500">{{ $session['ip_address'] ?? __('common.unknown_ip') }} &middot; {{ __('common.active_x_ago', ['time' => $session['last_active']->diffForHumans()]) }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.users.sessions.revoke', [$user, $session['id']]) }}" onsubmit="return confirm('{{ __('common.confirm_logout_device') }}');">
                        @csrf
                        @method('DELETE')
                        <button class="whitespace-nowrap rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">{{ __('common.log_out') }}</button>
                    </form>
                </li>
            @empty
                <li class="px-6 py-10 text-center text-sm text-gray-400">{{ __('common.no_active_sessions') }}</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
