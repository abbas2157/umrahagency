@extends('layouts.agency')

@section('title', __('common.agent_performance'))

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ __('common.agent_performance') }}</h2>
        <p class="text-sm text-gray-500">{{ __('common.agent_performance_note') }}</p>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.agent') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.branch') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.assigned') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.open') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.booked') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.lost_junk') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.conversion') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.avg_response') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($agents as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $row['agent']->name }}
                                @if ($row['agent']->designation)
                                    <div class="text-xs font-normal text-gray-400">{{ $row['agent']->designation }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $row['agent']->branch->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $row['total'] }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $row['open'] }}</td>
                            <td class="px-4 py-3 text-green-700">{{ $row['booked'] }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $row['lost'] }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $row['conversion_rate'] }}%</td>
                            <td class="px-4 py-3 text-gray-600">{{ \App\Models\User::formatResponseMinutes($row['avg_response_minutes']) }}</td>
                            <td class="px-4 py-3">
                                @if ($row['agent']->is_active)
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.active') }}</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.inactive') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_agents_yet') }} <a href="{{ route('agency.agents.create') }}" class="text-[#193670] underline">{{ __('common.add_your_first_one') }}</a>.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <p class="text-xs text-gray-400">{{ __('common.avg_response_footnote') }}</p>
</div>
@endsection
