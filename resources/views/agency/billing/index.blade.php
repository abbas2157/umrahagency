@extends('layouts.agency')

@section('title', 'Billing')

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Billing</h2>
        <p class="text-sm text-gray-500">Your plan and invoice history. Contact the platform administrator to change your plan or resolve a payment.</p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="text-sm font-medium text-gray-500">Current Plan</p>
        @if ($agency->plan)
            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $agency->plan->name }}</p>
            <p class="text-sm text-gray-500">PKR {{ number_format($agency->plan->price, 0) }} / {{ $agency->plan->billing_cycle }}</p>
            <p class="mt-1 text-xs text-gray-400">
                Active since {{ $agency->plan_activated_at?->format('d M Y') ?? '—' }}
                @if ($agency->currentPeriodEnd())
                    &middot; current period ends {{ $agency->currentPeriodEnd()->format('d M Y') }}
                @endif
            </p>
            @if ($agency->plan->description)
                <p class="mt-2 text-sm text-gray-600">{{ $agency->plan->description }}</p>
            @endif
        @else
            <p class="mt-1 text-sm text-gray-400">No plan assigned yet — contact the platform administrator.</p>
        @endif
    </div>

    <div>
        <p class="mb-3 text-sm font-medium text-gray-500">Available Plans</p>
        @if ($plans->isEmpty())
            <p class="rounded-xl border border-gray-200 bg-white p-5 text-sm text-gray-400 shadow-sm">No plans have been set up yet.</p>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($plans as $plan)
                    @php $isCurrent = $agency->plan_id === $plan->id; @endphp
                    <div class="relative rounded-xl border p-5 shadow-sm {{ $isCurrent ? 'border-[#193670] ring-1 ring-[#193670]' : 'border-gray-200 bg-white' }}">
                        @if ($isCurrent)
                            <span class="absolute -top-2.5 right-4 rounded-full bg-[#193670] px-2.5 py-0.5 text-xs font-medium text-white">Current Plan</span>
                        @endif
                        <p class="text-lg font-semibold text-gray-900">{{ $plan->name }}</p>
                        <p class="text-sm text-gray-500">PKR {{ number_format($plan->price, 0) }} / {{ $plan->billing_cycle }}</p>
                        @if ($plan->description)
                            <p class="mt-2 text-sm text-gray-600">{{ $plan->description }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
            <p class="mt-3 text-xs text-gray-400">To change plans, contact the platform administrator.</p>
        @endif
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-gray-900">Invoices ({{ $invoices->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Period</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Plan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Amount</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td class="px-4 py-3 text-gray-600">{{ $invoice->period_start->format('d M Y') }} – {{ $invoice->period_end->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $invoice->plan_name_snapshot }}</td>
                            <td class="px-4 py-3 text-gray-900">PKR {{ number_format($invoice->amount, 0) }}</td>
                            <td class="px-4 py-3">
                                @if ($invoice->status === 'paid')
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">Paid</span>
                                    <div class="mt-1 text-xs text-gray-400">{{ $invoice->paid_at->format('d M Y') }}</div>
                                @elseif ($invoice->status === 'cancelled')
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">Cancelled</span>
                                @elseif ($invoice->isOverdue())
                                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">Overdue</span>
                                @else
                                    <span class="rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-medium text-yellow-700">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">No invoices yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
