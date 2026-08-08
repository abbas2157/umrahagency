@extends('layouts.agency')

@section('title', __('common.my_agents'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('common.my_agents') }}</h2>
            <p class="text-sm text-gray-500">{{ __('common.total_count', ['count' => $agents->total()]) }}</p>
        </div>
        <a href="{{ route('agency.agents.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_agent') }}</a>
    </div>

    @if ($errors->any())
        <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="GET" class="flex gap-2">
        <select name="branch_id" onchange="this.form.submit()"
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            <option value="">{{ __('common.all_branches') }}</option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}" {{ (string) request('branch_id') === (string) $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
            @endforeach
        </select>
    </form>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.name') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.email') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.branch') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.last_login') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($agents as $agent)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $agent->name }}
                                @if ($agent->designation)
                                    <div class="text-xs font-normal text-gray-400">{{ $agent->designation }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $agent->email }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $agent->branch->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-500">
                                @if ($agent->last_login_at)
                                    {{ $agent->last_login_at->diffForHumans() }}
                                @else
                                    <span class="text-gray-400">{{ __('common.never') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($agent->is_active)
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.active') }}</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.inactive') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('agency.agents.sessions', $agent) }}" class="rounded-md bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100">{{ __('common.sessions') }}</a>
                                    <a href="{{ route('agency.agents.edit', $agent) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">{{ __('common.edit') }}</a>
                                    @if ($agent->is_active)
                                        <form method="POST" action="{{ route('agency.agents.deactivate', $agent) }}" onsubmit="return confirm('{{ __('common.confirm_deactivate_agent') }}');">
                                            @csrf
                                            @method('PATCH')
                                            <button class="rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">{{ __('common.deactivate') }}</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('agency.agents.activate', $agent) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="rounded-md bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-100">{{ __('common.activate') }}</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_agents_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $agents->links() }}
</div>
@endsection
