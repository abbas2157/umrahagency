@extends('layouts.admin')

@section('title', $agency->name)

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.agencies.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">
        &larr; {{ __('common.back_to_agencies') }}
    </a>

    <div class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            @if ($agency->logo_path)
                <img src="{{ $agency->logo_path }}" alt="{{ $agency->name }}" class="h-14 w-14 flex-shrink-0 rounded-lg border border-gray-200 bg-white object-contain">
            @endif
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-bold text-gray-900">{{ $agency->name }}</h2>
                    <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $agency->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $agency->is_active ? __('common.active') : __('common.inactive') }}</span>
                </div>
                <p class="text-sm text-gray-500">{{ $agency->slug }} &middot; {{ __('common.profile_percent_complete', ['percent' => $agency->completionPercentage()]) }}</p>
            </div>
        </div>
        <a href="{{ route('admin.agencies.edit', $agency) }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.edit_agency_button') }}</a>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-gray-500">{{ __('common.plan') }}</p>
                @if ($agency->plan)
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $agency->plan->name }}</p>
                    <p class="text-sm text-gray-500">PKR {{ number_format($agency->plan->price, 0) }} / {{ $agency->plan->billing_cycle }}</p>
                    <p class="mt-1 text-xs text-gray-400">
                        {{ __('common.active_since', ['date' => $agency->plan_activated_at?->format('d M Y') ?? '—']) }}
                        @if ($agency->currentPeriodEnd())
                            &middot; {{ __('common.current_period_ends', ['date' => $agency->currentPeriodEnd()->format('d M Y')]) }}
                        @endif
                    </p>
                    <form method="POST" action="{{ route('admin.agencies.plan.remove', $agency) }}" onsubmit="return confirm('{{ __('common.confirm_remove_plan') }}');" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button class="text-xs font-medium text-red-600 hover:underline">{{ __('common.remove_plan') }}</button>
                    </form>
                @else
                    <p class="mt-1 text-sm text-gray-400">{{ __('common.no_plan_assigned') }}</p>
                @endif
            </div>

            <form method="POST" action="{{ route('admin.agencies.plan.activate', $agency) }}" class="flex flex-wrap items-end gap-2">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-500">{{ __('common.plan') }}</label>
                    <select name="plan_id" required class="mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                        <option value="">{{ __('common.select_a_plan') }}</option>
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}" {{ $agency->plan_id === $plan->id ? 'selected' : '' }}>{{ $plan->name }} — PKR {{ number_format($plan->price, 0) }}/{{ $plan->billing_cycle }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500">{{ __('common.starts_on') }}</label>
                    <input type="date" name="starts_on" required value="{{ now()->toDateString() }}"
                        class="mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                </div>
                <button class="whitespace-nowrap rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.activate_plan') }}</button>
            </form>
        </div>
        @if ($agency->plan)
            <p class="mt-3 text-xs text-gray-400">{{ __('common.activation_note') }}</p>
        @endif
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-gray-900">{{ __('common.invoices') }} ({{ $invoices->count() }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.period') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.plan') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.amount') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
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
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.paid') }}</span>
                                    <div class="mt-1 text-xs text-gray-400">{{ __('common.amount_paid_via', ['date' => $invoice->paid_at->format('d M Y'), 'method' => $invoice->payment_method]) }}{{ $invoice->payment_reference ? ' ('.$invoice->payment_reference.')' : '' }}</div>
                                @elseif ($invoice->status === 'cancelled')
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.cancelled') }}</span>
                                @elseif ($invoice->isOverdue())
                                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">{{ __('common.overdue') }}</span>
                                @else
                                    <span class="rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-medium text-yellow-700">{{ __('common.pending') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if ($invoice->status === 'pending')
                                    <form method="POST" action="{{ route('admin.invoices.mark-paid', $invoice) }}" class="flex items-center justify-end gap-1.5">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="payment_method" required placeholder="{{ __('common.method_placeholder') }}"
                                            class="w-40 rounded-md border border-gray-300 px-2 py-1 text-xs focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                                        <input type="text" name="payment_reference" placeholder="{{ __('common.reference_placeholder') }}"
                                            class="w-28 rounded-md border border-gray-300 px-2 py-1 text-xs focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                                        <button class="whitespace-nowrap rounded-md bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-100">{{ __('common.mark_paid') }}</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.invoices.cancel', $invoice) }}" onsubmit="return confirm('{{ __('common.confirm_cancel_invoice') }}');" class="mt-1 flex justify-end">
                                        @csrf
                                        @method('PATCH')
                                        <button class="rounded-md bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-100">{{ __('common.cancel') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">{{ __('common.no_invoices_recorded_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-100 px-5 py-4">
            <p class="mb-3 text-sm font-semibold text-gray-900">{{ __('common.record_an_invoice') }}</p>
            <form method="POST" action="{{ route('admin.agencies.invoices.store', $agency) }}" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">
                @csrf
                <select name="plan_id" class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                    <option value="">{{ __('common.use_current_plan') }}</option>
                    @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}">{{ $plan->name }} — PKR {{ number_format($plan->price, 0) }}</option>
                    @endforeach
                </select>
                <input type="number" name="amount" step="0.01" min="0" required placeholder="{{ __('common.amount_pkr') }}"
                    value="{{ $agency->plan->price ?? '' }}"
                    class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                <input type="date" name="period_start" required class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                <input type="date" name="period_end" required class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                <button class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_invoice') }}</button>
            </form>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="mb-3 text-sm font-medium text-gray-500">{{ __('common.contact') }}</p>
        @php
            $address = collect([$agency->address_line, $agency->address_area, $agency->city, $agency->province])->filter()->implode(', ');
        @endphp
        <dl class="grid grid-cols-1 gap-x-6 gap-y-1.5 text-sm text-gray-600 sm:grid-cols-2">
            @if ($address)
                <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">{{ __('common.address') }}</dt><dd>{{ $address }}</dd></div>
            @endif
            @if ($agency->phone_local)
                <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">{{ __('common.phone') }}</dt><dd>{{ $agency->phone_local }}</dd></div>
            @endif
            @if ($agency->whatsapp)
                <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">{{ __('common.whatsapp') }}</dt><dd>{{ $agency->whatsapp }}</dd></div>
            @endif
            @if ($agency->email_general)
                <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">{{ __('common.email') }}</dt><dd>{{ $agency->email_general }}</dd></div>
            @endif
            @if (! $address && ! $agency->phone_local && ! $agency->whatsapp && ! $agency->email_general)
                <p class="text-gray-400">{{ __('common.no_contact_details_yet') }}</p>
            @endif
        </dl>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-gray-900">{{ __('common.branches') }} ({{ $branches->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.name') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.area_city') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.phone') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.agents') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($branches as $branch)
                        <tr>
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $branch->name }}
                                @if ($branch->is_main)
                                    <span class="ml-1 rounded-full bg-blue-50 px-1.5 py-0.5 text-xs font-medium text-blue-700">{{ __('common.main') }}</span>
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
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.active') }}</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.inactive') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">{{ __('common.no_branches_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-gray-900">{{ __('common.agents') }} ({{ $agents->count() }})</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.agent') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.branch') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.assigned') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.booked') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.conversion') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.avg_response') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
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
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.active') }}</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.inactive') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">{{ __('common.no_agents_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="mb-3 text-sm font-medium text-gray-500">{{ __('common.coverage_heading', ['count' => $coverageCities->count(), 'cities' => $coverageCities->count() === 1 ? __('common.city_singular') : __('common.city_plural')]) }}</p>
        @if ($coverageCities->isEmpty())
            <p class="text-sm text-gray-400">{{ __('common.no_cities_selected') }}</p>
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
