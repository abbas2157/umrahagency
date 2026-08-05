@extends('layouts.admin')

@section('title', 'Inquiry Details')

@section('content')
<div class="max-w-3xl space-y-6">
    <a href="{{ route('admin.inquiries.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">
        &larr; Back to inquiries
    </a>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $inquiry->name ?? 'Unnamed Inquiry' }}</h2>
                <p class="text-sm text-gray-500">Submitted {{ $inquiry->created_at->format('d M Y, h:i A') }}</p>
            </div>
            @if (auth()->user()->isSuperAdmin())
                <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" onsubmit="return confirm('Delete this inquiry?');">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg bg-red-50 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-100">Delete</button>
                </form>
            @endif
        </div>

        <dl class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">Email</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->email ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">Phone</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->phone ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">Departure Airport</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->departure_airport ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">Departure Date</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->departure_date ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">Hotel Category</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->hotel_category ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">Duration</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->duration ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium uppercase text-gray-400">Travelers</dt>
                <dd class="mt-1 text-gray-900">{{ $inquiry->travelers ?? '—' }}</dd>
            </div>
        </dl>

        <div class="mt-6">
            <dt class="text-xs font-medium uppercase text-gray-400">Message</dt>
            <dd class="mt-1 whitespace-pre-line rounded-lg bg-gray-50 p-4 text-sm text-gray-700">{{ $inquiry->message ?? 'No message provided.' }}</dd>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        @if (auth()->user()->isSuperAdmin())
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-900">Agency</h3>
                <p class="mt-1 text-sm text-gray-500">{{ $inquiry->agency->name ?? 'Not yet assigned to an agency.' }}</p>
                <form method="POST" action="{{ route('admin.inquiries.assign-agency', $inquiry) }}" class="mt-3 flex gap-2">
                    @csrf
                    <select name="agency_id" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                        <option value="">— Select an agency —</option>
                        @foreach ($agencies as $agency)
                            <option value="{{ $agency->id }}" {{ $inquiry->agency_id === $agency->id ? 'selected' : '' }}>{{ $agency->name }}</option>
                        @endforeach
                    </select>
                    <button class="whitespace-nowrap rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Assign</button>
                </form>
            </div>
        @endif

        @if (auth()->user()->isSuperAdmin() || auth()->user()->isAgencyAdmin())
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-900">Agent</h3>
                <p class="mt-1 text-sm text-gray-500">{{ $inquiry->assignedAgent->name ?? 'Not yet assigned to an agent.' }}</p>
                @if ($inquiry->agency_id)
                    <form method="POST" action="{{ route('admin.inquiries.assign-agent', $inquiry) }}" class="mt-3 flex gap-2">
                        @csrf
                        <select name="agent_id" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                            <option value="">— Select an agent —</option>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}" {{ $inquiry->assigned_agent_id === $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                            @endforeach
                        </select>
                        <button class="whitespace-nowrap rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Assign</button>
                    </form>
                    @if ($agents->isEmpty())
                        <p class="mt-2 text-xs text-amber-600">No agents in this agency yet.</p>
                    @endif
                @else
                    <p class="mt-3 text-xs text-amber-600">Assign this query to an agency first.</p>
                @endif
            </div>
        @endif
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-900">Status</h3>
        <form method="POST" action="{{ route('admin.inquiries.status', $inquiry) }}" class="mt-3 space-y-3">
            @csrf
            <select name="status" onchange="document.getElementById('lost-reason-field').classList.toggle('hidden', this.value !== 'lost')"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670] sm:w-64">
                @foreach (\App\Models\Inquiry::STATUSES as $status)
                    <option value="{{ $status }}" {{ $inquiry->status === $status ? 'selected' : '' }}>{{ str($status)->headline() }}</option>
                @endforeach
            </select>

            <div id="lost-reason-field" class="{{ $inquiry->status === 'lost' ? '' : 'hidden' }}">
                <label class="block text-sm font-medium text-gray-700">Loss reason</label>
                <select name="lost_reason" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670] sm:w-64">
                    <option value="">— Select a reason —</option>
                    @foreach (\App\Models\Inquiry::LOST_REASONS as $reason)
                        <option value="{{ $reason }}" {{ $inquiry->lost_reason === $reason ? 'selected' : '' }}>{{ $reason }}</option>
                    @endforeach
                </select>
                @error('lost_reason') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <button class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Update Status</button>
        </form>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-900">Activity</h3>

        <form method="POST" action="{{ route('admin.inquiries.notes', $inquiry) }}" class="mt-3 flex gap-2">
            @csrf
            <input type="text" name="note" required placeholder="Add a note..."
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            <button class="whitespace-nowrap rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Add Note</button>
        </form>

        <ul class="mt-5 space-y-4">
            @forelse ($inquiry->activities->sortByDesc('created_at') as $activity)
                <li class="border-l-2 border-gray-200 pl-4">
                    <p class="text-xs text-gray-400">
                        {{ $activity->created_at->format('d M Y, h:i A') }} &middot; {{ $activity->user->name ?? 'System' }}
                    </p>
                    <p class="mt-0.5 text-sm text-gray-700">
                        @if ($activity->type === 'status_change')
                            Status changed from <strong>{{ str($activity->old_value)->headline() }}</strong> to <strong>{{ str($activity->new_value)->headline() }}</strong>
                            @if ($activity->note) &mdash; {{ $activity->note }} @endif
                        @elseif ($activity->type === 'assignment')
                            {{ $activity->note }}: <strong>{{ $activity->old_value }}</strong> &rarr; <strong>{{ $activity->new_value }}</strong>
                        @else
                            {{ $activity->note }}
                        @endif
                    </p>
                </li>
            @empty
                <li class="text-sm text-gray-400">No activity yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
