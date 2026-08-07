@extends('layouts.agency')

@section('title', __('common.query_details'))

@section('content')
<div class="space-y-6">
    <a href="{{ route('agency.inquiries.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">
        &larr; {{ __('common.back_to_queries') }}
    </a>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ $inquiry->name ?? __('common.unnamed_inquiry') }}</h2>
            <p class="text-sm text-gray-500">{{ __('common.submitted_on', ['date' => $inquiry->created_at->format('d M Y, h:i A')]) }}</p>
        </div>

        <dl class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">{{ __('common.email') }}</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->email ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">{{ __('common.phone') }}</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->phone ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">{{ __('common.departure_airport') }}</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->departure_airport ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">{{ __('common.departure_date') }}</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->departure_date ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">{{ __('common.hotel_category') }}</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->hotel_category ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">{{ __('common.duration') }}</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->duration ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">{{ __('common.travelers') }}</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->travelers ?? '—' }}</dd>
            </div>
        </dl>

        <div class="mt-6">
            <dt class="text-xs font-medium uppercase text-gray-400">{{ __('common.message') }}</dt>
            <dd class="mt-1 whitespace-pre-line rounded-lg bg-gray-50 p-4 text-sm text-gray-700">{{ $inquiry->message ?? __('common.no_message_provided') }}</dd>
        </div>
    </div>

    @if (auth()->user()->isAgencyAdmin())
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900">{{ __('common.agent') }}</h3>
            <p class="mt-1 text-sm text-gray-500">{{ $inquiry->assignedAgent->name ?? __('common.not_yet_assigned_to_agent') }}</p>
            @if ($inquiry->agency_id)
                <form method="POST" action="{{ route('agency.inquiries.assign-agent', $inquiry) }}" class="mt-3 flex gap-2">
                    @csrf
                    <select name="agent_id" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                        <option value="">{{ __('common.select_an_agent') }}</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}" {{ $inquiry->assigned_agent_id === $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                        @endforeach
                    </select>
                    <button class="whitespace-nowrap rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.assign') }}</button>
                </form>
                @if ($agents->isEmpty())
                    <p class="mt-2 text-xs text-amber-600">{{ __('common.no_agents_add_one') }} <a href="{{ route('agency.agents.create') }}" class="underline">{{ __('common.add_one') }}</a>.</p>
                @endif
            @endif
        </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-900">{{ __('common.status') }}</h3>
        <form method="POST" action="{{ route('agency.inquiries.status', $inquiry) }}" class="mt-3 space-y-3">
            @csrf
            <select name="status" onchange="document.getElementById('lost-reason-field').classList.toggle('hidden', this.value !== 'lost')"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670] sm:w-64">
                @foreach (\App\Models\Inquiry::STATUSES as $status)
                    <option value="{{ $status }}" {{ $inquiry->status === $status ? 'selected' : '' }}>{{ __('common.status_'.$status) }}</option>
                @endforeach
            </select>

            <div id="lost-reason-field" class="{{ $inquiry->status === 'lost' ? '' : 'hidden' }}">
                <label class="block text-sm font-medium text-gray-700">{{ __('common.loss_reason') }}</label>
                @php
                    $lostReasonKeys = [
                        'Price too high' => 'lost_reason_price_too_high',
                        'Booked with another agency' => 'lost_reason_booked_elsewhere',
                        'Dates changed' => 'lost_reason_dates_changed',
                        'Not reachable after multiple attempts' => 'lost_reason_not_reachable',
                        'Just browsing' => 'lost_reason_just_browsing',
                        'Budget not ready' => 'lost_reason_budget_not_ready',
                        'Wanted unavailable hotel' => 'lost_reason_unavailable_hotel',
                        'Visa concern' => 'lost_reason_visa_concern',
                        'Other' => 'lost_reason_other',
                    ];
                @endphp
                <select name="lost_reason" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670] sm:w-64">
                    <option value="">{{ __('common.select_a_reason') }}</option>
                    @foreach (\App\Models\Inquiry::LOST_REASONS as $reason)
                        <option value="{{ $reason }}" {{ $inquiry->lost_reason === $reason ? 'selected' : '' }}>{{ __('common.'.$lostReasonKeys[$reason]) }}</option>
                    @endforeach
                </select>
                @error('lost_reason') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <button class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.update_status') }}</button>
        </form>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-900">{{ __('common.activity') }}</h3>

        <form method="POST" action="{{ route('agency.inquiries.notes', $inquiry) }}" class="mt-3 flex gap-2">
            @csrf
            <input type="text" name="note" required placeholder="{{ __('common.add_note_placeholder') }}"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            <button class="whitespace-nowrap rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_note') }}</button>
        </form>

        <ul class="mt-5 space-y-4">
            @forelse ($inquiry->activities->sortByDesc('created_at') as $activity)
                <li class="border-l-2 border-gray-200 pl-4">
                    <p class="text-xs text-gray-400">
                        {{ $activity->created_at->format('d M Y, h:i A') }} &middot; {{ $activity->user->name ?? __('common.system') }}
                    </p>
                    <p class="mt-0.5 text-sm text-gray-700">
                        @if ($activity->type === 'status_change')
                            {!! str_replace(
                                [':from', ':to'],
                                ['<strong>'.__('common.status_'.$activity->old_value).'</strong>', '<strong>'.__('common.status_'.$activity->new_value).'</strong>'],
                                __('common.status_changed_from_to')
                            ) !!}
                            @if ($activity->note) &mdash; {{ $activity->note }} @endif
                        @elseif ($activity->type === 'assignment')
                            {{ $activity->note }}: <strong>{{ $activity->old_value }}</strong> &rarr; <strong>{{ $activity->new_value }}</strong>
                        @else
                            {{ $activity->note }}
                        @endif
                    </p>
                </li>
            @empty
                <li class="text-sm text-gray-400">{{ __('common.no_activity_yet') }}</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
