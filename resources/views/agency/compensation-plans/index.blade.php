@extends('layouts.agency')

@section('title', __('common.compensation_plans'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('common.compensation_plans') }}</h2>
            <p class="text-sm text-gray-500">{{ __('common.total_count', ['count' => $plans->count()]) }}</p>
        </div>
        <a href="{{ route('agency.compensation-plans.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_compensation_plan') }}</a>
    </div>

    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.plan_name') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.compensation_type') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.assigned_agents') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($plans as $plan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $plan->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ __('common.comp_type_'.$plan->type) }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $plan->assignments_count }}</td>
                            <td class="px-4 py-3">
                                @if ($plan->is_active)
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.active') }}</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.inactive') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('agency.compensation-plans.edit', $plan) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">{{ __('common.edit') }}</a>
                                    @if ($plan->is_active)
                                        <form method="POST" action="{{ route('agency.compensation-plans.deactivate', $plan) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">{{ __('common.deactivate') }}</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('agency.compensation-plans.activate', $plan) }}">
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
                            <td colspan="5" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_compensation_plans_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">{{ __('common.assign_plan_to_agent') }}</h3>

        @if ($plans->where('is_active', true)->isEmpty())
            <p class="text-sm text-gray-400">{{ __('common.no_active_plans_hint') }}</p>
        @else
            <div class="space-y-3">
                @foreach ($agents as $agent)
                    @php $current = $agent->compensationHistory->first(); @endphp
                    <form method="POST" action="{{ route('agency.compensation-plans.assign', $agent) }}" class="flex flex-wrap items-end gap-3 rounded-lg border border-gray-100 p-3">
                        @csrf
                        <div class="min-w-[10rem]">
                            <p class="text-sm font-medium text-gray-900">{{ $agent->name }}</p>
                            <p class="text-xs text-gray-400">
                                {{ __('common.current_plan') }}: {{ $current?->plan?->name ?? __('common.none') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">{{ __('common.plan') }}</label>
                            <select name="plan_id" required class="mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                                @foreach ($plans->where('is_active', true) as $plan)
                                    <option value="{{ $plan->id }}" {{ $current?->plan_id === $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">{{ __('common.effective_from') }}</label>
                            <input type="date" name="effective_from" value="{{ now()->format('Y-m-d') }}" required class="mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                        </div>
                        <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.assign') }}</button>
                    </form>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
