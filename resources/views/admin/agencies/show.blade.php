@extends('layouts.admin')

@section('title', $agency->name)

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.agencies.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">
        &larr; Back to agencies
    </a>

    <div class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            @if ($agency->logo_path)
                <img src="{{ $agency->logo_path }}" alt="{{ $agency->name }}" class="h-14 w-14 flex-shrink-0 rounded-lg border border-gray-200 bg-white object-contain">
            @endif
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-bold text-gray-900">{{ $agency->name }}</h2>
                    <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $agency->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $agency->is_active ? 'Active' : 'Inactive' }}</span>
                </div>
                <p class="text-sm text-gray-500">{{ $agency->slug }} &middot; Profile {{ $agency->completionPercentage() }}% complete</p>
            </div>
        </div>
        <a href="{{ route('admin.agencies.edit', $agency) }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Edit Agency</a>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-sm font-medium text-gray-500">Plan</p>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $agency->plan?->name ?? 'No plan assigned' }}</p>
                @if ($agency->plan)
                    <p class="text-sm text-gray-500">PKR {{ number_format($agency->plan->price, 0) }} / {{ $agency->plan->billing_cycle }}</p>
                @endif
            </div>
            <form method="POST" action="{{ route('admin.agencies.update-plan', $agency) }}" class="flex gap-2">
                @csrf
                @method('PATCH')
                <select name="plan_id" class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                    <option value="">No plan</option>
                    @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}" {{ $agency->plan_id === $plan->id ? 'selected' : '' }}>{{ $plan->name }} — PKR {{ number_format($plan->price, 0) }}/{{ $plan->billing_cycle }}</option>
                    @endforeach
                </select>
                <button class="whitespace-nowrap rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Change Plan</button>
            </form>
        </div>
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
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">Actions</th>
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
                                    <div class="mt-1 text-xs text-gray-400">{{ $invoice->paid_at->format('d M Y') }} via {{ $invoice->payment_method }}{{ $invoice->payment_reference ? ' ('.$invoice->payment_reference.')' : '' }}</div>
                                @elseif ($invoice->status === 'cancelled')
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">Cancelled</span>
                                @elseif ($invoice->isOverdue())
                                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">Overdue</span>
                                @else
                                    <span class="rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-medium text-yellow-700">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if ($invoice->status === 'pending')
                                    <form method="POST" action="{{ route('admin.invoices.mark-paid', $invoice) }}" class="flex items-center justify-end gap-1.5">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="payment_method" required placeholder="Method (e.g. Bank Transfer)"
                                            class="w-40 rounded-md border border-gray-300 px-2 py-1 text-xs focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                                        <input type="text" name="payment_reference" placeholder="Reference"
                                            class="w-28 rounded-md border border-gray-300 px-2 py-1 text-xs focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                                        <button class="whitespace-nowrap rounded-md bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-100">Mark Paid</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.invoices.cancel', $invoice) }}" onsubmit="return confirm('Cancel this invoice?');" class="mt-1 flex justify-end">
                                        @csrf
                                        @method('PATCH')
                                        <button class="rounded-md bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-100">Cancel</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">No invoices recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-100 px-5 py-4">
            <p class="mb-3 text-sm font-semibold text-gray-900">Record an invoice</p>
            <form method="POST" action="{{ route('admin.agencies.invoices.store', $agency) }}" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">
                @csrf
                <select name="plan_id" class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                    <option value="">Use current plan</option>
                    @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}">{{ $plan->name }} — PKR {{ number_format($plan->price, 0) }}</option>
                    @endforeach
                </select>
                <input type="number" name="amount" step="0.01" min="0" required placeholder="Amount (PKR)"
                    value="{{ $agency->plan->price ?? '' }}"
                    class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                <input type="date" name="period_start" required class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                <input type="date" name="period_end" required class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                <button class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Add Invoice</button>
            </form>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="mb-3 text-sm font-medium text-gray-500">Contact</p>
        @php
            $address = collect([$agency->address_line, $agency->address_area, $agency->city, $agency->province])->filter()->implode(', ');
        @endphp
        <dl class="grid grid-cols-1 gap-x-6 gap-y-1.5 text-sm text-gray-600 sm:grid-cols-2">
            @if ($address)
                <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Address</dt><dd>{{ $address }}</dd></div>
            @endif
            @if ($agency->phone_local)
                <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Phone</dt><dd>{{ $agency->phone_local }}</dd></div>
            @endif
            @if ($agency->whatsapp)
                <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">WhatsApp</dt><dd>{{ $agency->whatsapp }}</dd></div>
            @endif
            @if ($agency->email_general)
                <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Email</dt><dd>{{ $agency->email_general }}</dd></div>
            @endif
            @if (! $address && ! $agency->phone_local && ! $agency->whatsapp && ! $agency->email_general)
                <p class="text-gray-400">No contact details filled in yet.</p>
            @endif
        </dl>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-gray-900">Branches ({{ $branches->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Area / City</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Phone</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Agents</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($branches as $branch)
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $branch->name }}
                                @if ($branch->is_main)
                                    <span class="ml-1 rounded-full bg-blue-50 px-1.5 py-0.5 text-xs font-medium text-blue-700">Main</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                <div>{{ $branch->area ?? '—' }}</div>
                                <div class="text-gray-400">{{ $branch->city?->name ?? '—' }}{{ $branch->city?->province ? ', '.$branch->city->province->name : '' }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $branch->phone }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $branch->agents()->count() }}</td>
                            <td class="px-4 py-3">
                                @if ($branch->is_active)
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">Active</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">No branches yet — the agency admin hasn't added one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-gray-900">Agents ({{ $agents->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Agent</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Branch</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Assigned</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Booked</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Conversion</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Avg. Response</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($agents as $row)
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $row['agent']->name }}
                                @if ($row['agent']->designation)
                                    <div class="text-xs font-normal text-gray-400">{{ $row['agent']->designation }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $row['agent']->branch->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $row['total'] }}</td>
                            <td class="px-4 py-3 text-green-700">{{ $row['booked'] }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $row['conversion_rate'] }}%</td>
                            <td class="px-4 py-3 text-gray-600">{{ \App\Models\User::formatResponseMinutes($row['avg_response_minutes']) }}</td>
                            <td class="px-4 py-3">
                                @if ($row['agent']->is_active)
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">Active</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">No agents yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="mb-3 text-sm font-medium text-gray-500">Coverage ({{ $coverageCities->count() }} {{ str('city')->plural($coverageCities->count()) }})</p>
        @if ($coverageCities->isEmpty())
            <p class="text-sm text-gray-400">No cities selected — this agency won't receive any auto-routed queries.</p>
        @else
            <div class="flex flex-wrap gap-2">
                @foreach ($coverageCities as $city)
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">{{ $city->name }}@if ($city->province), {{ $city->province->name }}@endif</span>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
