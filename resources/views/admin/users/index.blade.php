@extends('layouts.admin')

@section('title', __('common.users'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('common.users') }}</h2>
            <p class="text-sm text-gray-500">{{ __('common.total_count', ['count' => $users->total()]) }}</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_user') }}</a>
    </div>

    @if ($errors->any())
        <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.name') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.email') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.role') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.agency') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.last_login') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $user->name }}
                                @if ($user->is(auth()->user()))
                                    <span class="ml-1 text-xs text-gray-400">({{ __('common.you') }})</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ __('common.role_'.$user->role) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->agency->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-500">
                                @if ($user->last_login_at)
                                    {{ $user->last_login_at->diffForHumans() }}
                                @else
                                    <span class="text-gray-400">{{ __('common.never') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($user->is_active)
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.active') }}</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.inactive') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.users.sessions', $user) }}" class="rounded-md bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100">{{ __('common.sessions') }}</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">{{ __('common.edit') }}</a>
                                    @unless ($user->is(auth()->user()))
                                        @if ($user->role === 'agent')
                                            @if ($user->is_active)
                                                <form method="POST" action="{{ route('admin.users.deactivate', $user) }}" onsubmit="return confirm('{{ __('common.confirm_deactivate_agent') }}');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">{{ __('common.deactivate') }}</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.users.activate', $user) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="rounded-md bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-100">{{ __('common.activate') }}</button>
                                                </form>
                                            @endif
                                        @else
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('{{ __('common.confirm_delete_user') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">{{ __('common.delete') }}</button>
                                            </form>
                                        @endif
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_users_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $users->links() }}
</div>
@endsection
