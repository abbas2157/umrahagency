@extends('layouts.agency')

@section('title', __('common.payroll').' — '.$payroll->period_month->format('F Y'))

@section('content')
<div class="max-w-4xl space-y-6">
    <a href="{{ route('agency.payrolls.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">&larr; {{ __('common.back_to_payrolls') }}</a>

    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('common.payroll') }} — {{ $payroll->period_month->format('F Y') }}</h2>
            <p class="text-sm text-gray-500">{{ __('common.payroll_status_'.$payroll->status) }}</p>
        </div>
        <div class="flex gap-2">
            @if ($payroll->status === 'draft')
                <form method="POST" action="{{ route('agency.payrolls.approve', $payroll) }}" onsubmit="return confirm('{{ __('common.confirm_approve_payroll') }}');">
                    @csrf
                    @method('PATCH')
                    <button class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.approve_payroll') }}</button>
                </form>
            @elseif ($payroll->status === 'approved')
                <form method="POST" action="{{ route('agency.payrolls.pay', $payroll) }}" onsubmit="return confirm('{{ __('common.confirm_pay_payroll') }}');">
                    @csrf
                    @method('PATCH')
                    <button class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">{{ __('common.mark_paid') }}</button>
                </form>
            @endif
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 text-left font-semibold text-gray-600">{{ __('common.assigned_agent') }}</th>
                        <th class="px-3 py-3 text-right font-semibold text-gray-600">{{ __('common.base_salary_short') }}</th>
                        <th class="px-3 py-3 text-right font-semibold text-gray-600">{{ __('common.commission') }}</th>
                        <th class="px-3 py-3 text-right font-semibold text-gray-600">{{ __('common.bonus') }}</th>
                        <th class="px-3 py-3 text-right font-semibold text-gray-600">{{ __('common.advance_deduct') }}</th>
                        <th class="px-3 py-3 text-right font-semibold text-gray-600">{{ __('common.other_deduct') }}</th>
                        <th class="px-3 py-3 text-right font-semibold text-gray-600">{{ __('common.tax_deduct') }}</th>
                        <th class="px-3 py-3 text-right font-semibold text-gray-600">{{ __('common.net_payable') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($payroll->items as $item)
                        <tr>
                            <td class="px-3 py-3 font-medium text-gray-900">{{ $item->agent->name ?? '—' }}</td>
                            <td class="px-3 py-3 text-right text-gray-700">{{ number_format($item->base_salary, 0) }}</td>
                            <td class="px-3 py-3 text-right text-gray-700">{{ number_format($item->commission, 0) }}</td>
                            @if ($payroll->status === 'draft')
                                <td class="px-3 py-3">
                                    <form method="POST" action="{{ route('agency.payrolls.items.update', [$payroll, $item]) }}" class="flex items-center justify-end gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" step="0.01" min="0" name="bonus" value="{{ $item->bonus }}" class="w-20 rounded-md border border-gray-300 px-2 py-1 text-right text-xs">
                                        <input type="number" step="0.01" min="0" name="other_deduct" value="{{ $item->other_deduct }}" class="w-20 rounded-md border border-gray-300 px-2 py-1 text-right text-xs" title="{{ __('common.other_deduct') }}">
                                        <input type="number" step="0.01" min="0" name="tax_deduct" value="{{ $item->tax_deduct }}" class="w-20 rounded-md border border-gray-300 px-2 py-1 text-right text-xs" title="{{ __('common.tax_deduct') }}">
                                        <button type="submit" class="rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700 hover:bg-gray-200">{{ __('common.save') }}</button>
                                    </form>
                                </td>
                                <td class="px-3 py-3 text-right text-gray-700">{{ number_format($item->advance_deduct, 0) }}</td>
                                <td class="px-3 py-3"></td>
                                <td class="px-3 py-3"></td>
                            @else
                                <td class="px-3 py-3 text-right text-gray-700">{{ number_format($item->bonus, 0) }}</td>
                                <td class="px-3 py-3 text-right text-gray-700">{{ number_format($item->advance_deduct, 0) }}</td>
                                <td class="px-3 py-3 text-right text-gray-700">{{ number_format($item->other_deduct, 0) }}</td>
                                <td class="px-3 py-3 text-right text-gray-700">{{ number_format($item->tax_deduct, 0) }}</td>
                            @endif
                            <td class="px-3 py-3 text-right font-semibold text-gray-900">{{ number_format($item->net_payable, 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_payroll_items') }}</td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($payroll->items->isNotEmpty())
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td class="px-3 py-3 text-right font-semibold text-gray-700" colspan="7">{{ __('common.total') }}</td>
                            <td class="px-3 py-3 text-right font-bold text-gray-900">{{ number_format($payroll->items->sum('net_payable'), 0) }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
