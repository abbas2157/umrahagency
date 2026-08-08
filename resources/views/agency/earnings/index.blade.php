@extends('layouts.agency')

@section('title', __('common.my_earnings'))

@section('content')
<div class="max-w-4xl space-y-6">
    <h2 class="text-2xl font-bold text-gray-900">{{ __('common.my_earnings') }}</h2>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">{{ __('common.current_compensation_plan') }}</h3>
        @if ($currentCompensation)
            <dl class="grid grid-cols-2 gap-4 text-sm sm:grid-cols-3">
                <div>
                    <dt class="text-gray-400">{{ __('common.plan') }}</dt>
                    <dd class="mt-1 font-medium text-gray-900">{{ $currentCompensation->plan->name }}</dd>
                </div>
                <div>
                    <dt class="text-gray-400">{{ __('common.compensation_type') }}</dt>
                    <dd class="mt-1 font-medium text-gray-900">{{ __('common.comp_type_'.$currentCompensation->plan->type) }}</dd>
                </div>
                @if ($currentCompensation->plan->base_salary > 0)
                    <div>
                        <dt class="text-gray-400">{{ __('common.base_salary_short') }}</dt>
                        <dd class="mt-1 font-medium text-gray-900">{{ number_format($currentCompensation->plan->base_salary, 0) }}</dd>
                    </div>
                @endif
                @if ($currentCompensation->plan->commission_rate)
                    <div>
                        <dt class="text-gray-400">{{ __('common.commission_rate_percent') }}</dt>
                        <dd class="mt-1 font-medium text-gray-900">{{ $currentCompensation->plan->commission_rate }}%</dd>
                    </div>
                @endif
            </dl>
        @else
            <p class="text-sm text-gray-400">{{ __('common.no_compensation_plan_assigned') }}</p>
        @endif
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">{{ __('common.commissions') }}</h3>
        <div class="overflow-hidden rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.date') }}</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.booking') }}</th>
                        <th class="px-4 py-2 text-right font-semibold text-gray-600">{{ __('common.amount_pkr') }}</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($commissions as $commission)
                        <tr>
                            <td class="px-4 py-2 text-gray-600">{{ $commission->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-gray-500">#{{ $commission->booking_id }}</td>
                            <td class="px-4 py-2 text-right {{ $commission->amount < 0 ? 'text-red-600' : 'text-gray-900' }}">{{ number_format($commission->amount, 0) }}</td>
                            <td class="px-4 py-2 text-gray-500">{{ __('common.commission_status_'.$commission->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400">{{ __('common.no_commissions_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $commissions->links() }}
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">{{ __('common.payroll_history') }}</h3>
        <div class="overflow-hidden rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.period') }}</th>
                        <th class="px-4 py-2 text-right font-semibold text-gray-600">{{ __('common.net_payable') }}</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($payrollItems as $item)
                        <tr>
                            <td class="px-4 py-2 text-gray-600">{{ $item->payroll->period_month->format('F Y') }}</td>
                            <td class="px-4 py-2 text-right text-gray-900">{{ number_format($item->net_payable, 0) }}</td>
                            <td class="px-4 py-2 text-gray-500">{{ __('common.payroll_status_'.$item->payroll->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-400">{{ __('common.no_payrolls_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($advances->isNotEmpty())
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">{{ __('common.advances') }}</h3>
            <div class="overflow-hidden rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.issued_on') }}</th>
                            <th class="px-4 py-2 text-right font-semibold text-gray-600">{{ __('common.amount_pkr') }}</th>
                            <th class="px-4 py-2 text-right font-semibold text-gray-600">{{ __('common.balance_remaining') }}</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($advances as $advance)
                            <tr>
                                <td class="px-4 py-2 text-gray-600">{{ $advance->issued_on->format('d M Y') }}</td>
                                <td class="px-4 py-2 text-right text-gray-900">{{ number_format($advance->amount, 0) }}</td>
                                <td class="px-4 py-2 text-right text-gray-900">{{ number_format($advance->balance, 0) }}</td>
                                <td class="px-4 py-2 text-gray-500">{{ __('common.advance_status_'.$advance->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
