@extends(auth()->user()->isSuperAdmin() ? 'layouts.admin' : 'layouts.agency')

@section('title', __('common.my_account'))

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ __('common.my_account') }}</h2>
        <p class="text-sm text-gray-500">{{ $user->name }} &middot; {{ $user->email }} &middot; {{ __('common.role_'.$user->role) }}</p>
    </div>

    @if ($errors->any())
        <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-sm font-semibold text-gray-900">{{ __('common.profile') }}</h3>
        <form method="POST" action="{{ route('account.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('common.name') }}</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('common.email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <x-password-input name="password" :label="__('common.new_password')" :required="false" :placeholder="__('common.leave_blank_password_hint')" />
                <x-password-input name="password_confirmation" :label="__('common.confirm_new_password')" :required="false" />
                <div class="sm:col-span-2">
                    <x-password-input name="current_password" :label="__('common.current_password_label')" />
                </div>
            </div>
            <div class="pt-2">
                <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.save_changes') }}</button>
            </div>
        </form>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-900">{{ __('common.last_login') }}</h3>
        @if ($user->last_login_at)
            <p class="mt-1 text-sm text-gray-600">
                {{ $user->last_login_at->format('d M Y, h:i A') }}
                @if ($user->last_login_ip)
                    {!! str_replace(':ip', '<span class="font-medium text-gray-900">'.e($user->last_login_ip).'</span>', __('common.from_ip')) !!}
                @endif
            </p>
        @else
            <p class="mt-1 text-sm text-gray-400">{{ __('common.no_login_recorded') }}</p>
        @endif
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-900">{{ __('common.active_sessions') }}</h3>
                <p class="text-xs text-gray-500">{{ __('common.every_device_note') }}</p>
            </div>
            @if ($sessions->filter(fn ($s) => ! $s['is_current'])->isNotEmpty())
                <form method="POST" action="{{ route('account.sessions.revoke-others') }}" onsubmit="return confirm('{{ __('common.confirm_logout_all_others') }}');">
                    @csrf
                    <button class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">{{ __('common.log_out_all_others') }}</button>
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
                                <span class="ml-1 rounded-full bg-green-50 px-2 py-0.5 text-xs font-medium text-green-700">{{ __('common.this_device') }}</span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">{{ $session['ip_address'] ?? __('common.unknown_ip') }} &middot; {{ __('common.active_x_ago', ['time' => $session['last_active']->diffForHumans()]) }}</p>
                    </div>
                    @unless ($session['is_current'])
                        <form method="POST" action="{{ route('account.sessions.revoke', $session['id']) }}" onsubmit="return confirm('{{ __('common.confirm_logout_device') }}');">
                            @csrf
                            @method('DELETE')
                            <button class="whitespace-nowrap rounded-md bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100">{{ __('common.log_out') }}</button>
                        </form>
                    @endunless
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
