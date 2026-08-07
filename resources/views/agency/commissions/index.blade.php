@extends('layouts.agency')

@section('title', __('common.commissions'))

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ __('common.commissions') }}</h2>
        <p class="text-sm text-gray-500">{{ __('common.total_count', ['count' => $commissions->total()]) }}</p>
    </div>

    @if (session('success'))
        <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
    @endif

    <form method="GET" class="flex flex-wrap gap-2">
        <select name="agent_id" onchange="this.form.submit()"
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            <option value="">{{ __('common.all_agents') }}</option>
            @foreach ($agents as $agent)
                <option value="{{ $agent->id }}" {{ (string) request('agent_id') === (string) $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
            @endforeach
        </select>
        <select name="status" onchange="this.form.submit()"
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            <option value="">{{ __('common.all_statuses') }}</option>
            @foreach (['accrued', 'approved', 'paid', 'reversed'] as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ __('common.commission_status_'.$status) }}</option>
            @endforeach
        </select>
    </form>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.date') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.assigned_agent') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.booking') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.amount_pkr') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($commissions as $commission)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-600">{{ $commission->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-gray-900">{{ $commission->agent->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('agency.bookings.show', $commission->booking_id) }}" class="text-[#193670] hover:underline">#{{ $commission->booking_id }}</a>
                            </td>
                            <td class="px-4 py-3 text-right {{ $commission->amount < 0 ? 'text-red-600' : 'text-gray-900' }}">{{ number_format($commission->amount, 0) }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ __('common.commission_status_'.$commission->status) }}</td>
                            <td class="px-4 py-3 text-right">
                                @if ($commission->status === 'accrued')
                                    <form method="POST" action="{{ route('agency.commissions.approve', $commission) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="rounded-md bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-100">{{ __('common.approve') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_commissions_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $commissions->links() }}
</div>
@endsection
