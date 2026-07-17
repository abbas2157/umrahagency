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
            <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" onsubmit="return confirm('Delete this inquiry?');">
                @csrf
                @method('DELETE')
                <button class="rounded-lg bg-red-50 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-100">Delete</button>
            </form>
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
</div>
@endsection
