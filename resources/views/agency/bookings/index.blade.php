@extends('layouts.agency')

@section('title', __('common.bookings'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('common.bookings') }}</h2>
            <p class="text-sm text-gray-500">{{ __('common.total_count', ['count' => $bookings->total()]) }}</p>
        </div>
        <a href="{{ route('agency.bookings.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_booking') }}</a>
    </div>

    <form method="GET" class="flex gap-2">
        <select name="status" onchange="this.form.submit()"
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            <option value="">{{ __('common.all_statuses') }}</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('common.active') }}</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>{{ __('common.cancelled') }}</option>
        </select>
    </form>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.booking') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.package_tier') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.assigned_agent') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.total_price_pkr') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.received') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                #{{ $booking->id }}
                                <div class="text-xs font-normal text-gray-400">{{ $booking->booked_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ __('common.tier_'.$booking->package_tier) }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $booking->agent->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-right text-gray-900">{{ number_format($booking->total_price, 0) }}</td>
                            <td class="px-4 py-3 text-right text-gray-500">{{ number_format($booking->totalReceived(), 0) }}</td>
                            <td class="px-4 py-3">
                                @if ($booking->status === 'active')
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.active') }}</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.cancelled') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('agency.bookings.show', $booking) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">{{ __('common.view') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_bookings_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $bookings->links() }}
</div>
@endsection
