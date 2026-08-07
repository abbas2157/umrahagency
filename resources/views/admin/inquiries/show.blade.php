@extends('layouts.admin')

@section('title', __('common.inquiry_details'))

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.inquiries.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">
        &larr; {{ __('common.back_to_inquiries') }}
    </a>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $inquiry->name ?? __('common.unnamed_inquiry') }}</h2>
                <p class="text-sm text-gray-500">{{ __('common.submitted_on', ['date' => $inquiry->created_at->format('d M Y, h:i A')]) }}</p>
            </div>
            <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" onsubmit="return confirm('{{ __('common.confirm_delete_inquiry') }}');">
                @csrf
                @method('DELETE')
                <button class="rounded-lg bg-red-50 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-100">{{ __('common.delete') }}</button>
            </form>
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

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-900">{{ __('common.agency') }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ $inquiry->agency->name ?? __('common.not_yet_assigned_to_agency') }}</p>
        <form method="POST" action="{{ route('admin.inquiries.assign-agency', $inquiry) }}" class="mt-3 flex gap-2">
            @csrf
            <select name="agency_id" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                <option value="">{{ __('common.select_an_agency') }}</option>
                @foreach ($agencies as $agency)
                    <option value="{{ $agency->id }}" {{ $inquiry->agency_id === $agency->id ? 'selected' : '' }}>{{ $agency->name }}</option>
                @endforeach
            </select>
            <button class="whitespace-nowrap rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.assign') }}</button>
        </form>
        <p class="mt-3 text-xs text-gray-400">{{ __('common.once_assigned_note') }}</p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-900">{!! __('common.status_and_activity') !!}</h3>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('common.current_status') }}
            <span class="font-medium text-gray-900">{{ __('common.status_'.$inquiry->status) }}</span>
            @if ($inquiry->assignedAgent)
                {!! str_replace(':name', '<span class="font-medium text-gray-900">'.e($inquiry->assignedAgent->name).'</span>', __('common.assigned_to_x')) !!}
            @endif
        </p>

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
