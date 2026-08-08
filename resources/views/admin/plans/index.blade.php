@extends('layouts.admin')

@section('title', __('common.plans'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('common.plans') }}</h2>
            <p class="text-sm text-gray-500">{{ __('common.total_count', ['count' => $plans->count()]) }} {{ __('common.plans_pricing_note') }}</p>
        </div>
        <a href="{{ route('admin.plans.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_plan') }}</a>
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
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.price') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.cycle') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.agencies') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($plans as $plan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $plan->name }}</td>
                            <td class="px-4 py-3 text-gray-600">PKR {{ number_format($plan->price, 0) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ __('common.cycle_'.$plan->billing_cycle) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $plan->agencies_count }}</td>
                            <td class="px-4 py-3">
                                @if ($plan->is_active)
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.active') }}</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.inactive') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.plans.edit', $plan) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">{{ __('common.edit') }}</a>
                                    @if ($plan->is_active)
                                        <form method="POST" action="{{ route('admin.plans.deactivate', $plan) }}" onsubmit="return confirm('{{ __('common.confirm_deactivate_plan') }}');">
                                            @csrf
                                            @method('PATCH')
                                            <button class="rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">{{ __('common.deactivate') }}</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.plans.activate', $plan) }}">
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
                            <td colspan="6" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_plans_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
