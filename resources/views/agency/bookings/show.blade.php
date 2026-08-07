@extends('layouts.agency')

@section('title', __('common.booking').' #'.$booking->id)

@section('content')
<div class="max-w-3xl space-y-6">
    <a href="{{ route('agency.bookings.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">&larr; {{ __('common.back_to_bookings') }}</a>

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

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ __('common.booking') }} #{{ $booking->id }}</h2>
                <p class="text-sm text-gray-500">{{ __('common.tier_'.$booking->package_tier) }} &middot; {{ $booking->booked_at->format('d M Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                @if ($booking->status === 'active')
                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.active') }}</span>
                @else
                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.cancelled') }}</span>
                @endif
                <a href="{{ route('agency.bookings.edit', $booking) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">{{ __('common.edit') }}</a>
                @if (auth()->user()->isAgencyAdmin() && $booking->status === 'active')
                    <form method="POST" action="{{ route('agency.bookings.cancel', $booking) }}" onsubmit="return confirm('{{ __('common.confirm_cancel_booking') }}');">
                        @csrf
                        @method('PATCH')
                        <button class="rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">{{ __('common.cancel_booking') }}</button>
                    </form>
                @endif
            </div>
        </div>

        <dl class="mt-6 grid grid-cols-2 gap-4 text-sm sm:grid-cols-3">
            <div>
                <dt class="text-gray-400">{{ __('common.assigned_agent') }}</dt>
                <dd class="mt-1 font-medium text-gray-900">{{ $booking->agent->name ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-gray-400">{{ __('common.linked_inquiry') }}</dt>
                <dd class="mt-1 font-medium text-gray-900">
                    @if ($booking->inquiry)
                        <a href="{{ route('agency.inquiries.show', $booking->inquiry) }}" class="text-[#193670] hover:underline">#{{ $booking->inquiry->id }}</a>
                    @else
                        —
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-gray-400">{{ __('common.total_price_pkr') }}</dt>
                <dd class="mt-1 font-medium text-gray-900">{{ number_format($booking->total_price, 0) }}</dd>
            </div>
            <div>
                <dt class="text-gray-400">{{ __('common.received') }}</dt>
                <dd class="mt-1 font-medium text-gray-900">{{ number_format($booking->totalReceived(), 0) }}</dd>
            </div>
            <div>
                <dt class="text-gray-400">{{ __('common.balance_due') }}</dt>
                <dd class="mt-1 font-medium text-gray-900">{{ number_format(max($booking->total_price - $booking->totalReceived(), 0), 0) }}</dd>
            </div>
        </dl>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">{{ __('common.payments') }}</h3>

        <div class="overflow-hidden rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.date') }}</th>
                        <th class="px-4 py-2 text-right font-semibold text-gray-600">{{ __('common.amount_pkr') }}</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.method') }}</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        <th class="px-4 py-2 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($booking->payments as $payment)
                        <tr>
                            <td class="px-4 py-2 text-gray-600">{{ $payment->received_at->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-right text-gray-900">{{ number_format($payment->amount, 0) }}</td>
                            <td class="px-4 py-2 text-gray-500">{{ $payment->method ?? '—' }}</td>
                            <td class="px-4 py-2">
                                @if ($payment->status === 'received')
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.received') }}</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.refunded') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-right">
                                @if ($payment->status === 'received' && auth()->user()->isAgencyAdmin())
                                    <form method="POST" action="{{ route('agency.bookings.payments.refund', [$booking, $payment]) }}" onsubmit="return confirm('{{ __('common.confirm_refund_payment') }}');">
                                        @csrf
                                        @method('PATCH')
                                        <button class="rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">{{ __('common.refund') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-400">{{ __('common.no_payments_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($booking->status === 'active')
            <form method="POST" action="{{ route('agency.bookings.payments.store', $booking) }}" class="mt-4 flex flex-wrap items-end gap-3">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-700">{{ __('common.amount_pkr') }}</label>
                    <input type="number" step="0.01" min="0.01" name="amount" required class="mt-1 w-32 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">{{ __('common.date') }}</label>
                    <input type="date" name="received_at" value="{{ now()->format('Y-m-d') }}" required class="mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">{{ __('common.method') }}</label>
                    <input type="text" name="method" placeholder="{{ __('common.method_placeholder') }}" class="mt-1 w-36 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700">{{ __('common.reference_optional') }}</label>
                    <input type="text" name="reference" class="mt-1 w-36 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.record_payment') }}</button>
            </form>
        @endif
    </div>

    @if ($booking->commissions->isNotEmpty())
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">{{ __('common.commissions') }}</h3>
            <div class="overflow-hidden rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.date') }}</th>
                            <th class="px-4 py-2 text-right font-semibold text-gray-600">{{ __('common.amount_pkr') }}</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($booking->commissions as $commission)
                            <tr>
                                <td class="px-4 py-2 text-gray-600">{{ $commission->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-2 text-right {{ $commission->amount < 0 ? 'text-red-600' : 'text-gray-900' }}">{{ number_format($commission->amount, 0) }}</td>
                                <td class="px-4 py-2 text-gray-500">{{ __('common.commission_status_'.$commission->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
