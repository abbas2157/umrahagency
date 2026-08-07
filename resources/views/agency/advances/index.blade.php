@extends('layouts.agency')

@section('title', __('common.advances'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('common.advances') }}</h2>
            <p class="text-sm text-gray-500">{{ __('common.total_count', ['count' => $advances->total()]) }}</p>
        </div>
        <a href="{{ route('agency.advances.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.issue_advance') }}</a>
    </div>

    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.assigned_agent') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.issued_on') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.amount_pkr') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.balance_remaining') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.monthly_deduct') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($advances as $advance)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $advance->agent->name ?? '—' }}
                                @if ($advance->reason)
                                    <div class="text-xs font-normal text-gray-400">{{ $advance->reason }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $advance->issued_on->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right text-gray-900">{{ number_format($advance->amount, 0) }}</td>
                            <td class="px-4 py-3 text-right text-gray-900">{{ number_format($advance->balance, 0) }}</td>
                            <td class="px-4 py-3 text-right text-gray-500">{{ number_format($advance->monthly_deduct, 0) }}</td>
                            <td class="px-4 py-3">
                                @if ($advance->status === 'active')
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">{{ __('common.advance_status_active') }}</span>
                                @elseif ($advance->status === 'cleared')
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.advance_status_cleared') }}</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.advance_status_written_off') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if ($advance->status === 'active')
                                    <form method="POST" action="{{ route('agency.advances.write-off', $advance) }}" onsubmit="return confirm('{{ __('common.confirm_write_off_advance') }}');">
                                        @csrf
                                        @method('PATCH')
                                        <button class="rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">{{ __('common.write_off') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_advances_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $advances->links() }}
</div>
@endsection
