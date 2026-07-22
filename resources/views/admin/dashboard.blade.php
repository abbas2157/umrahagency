@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h2>
        <p class="text-sm text-gray-500">Here's what's happening with your website inquiries.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Total Inquiries</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_inquiries'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Inquiries Today</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['inquiries_today'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Last 7 Days</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['inquiries_this_week'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Contact Clicks</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_contact_clicks'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                <h3 class="text-sm font-semibold text-gray-900">Recent Inquiries</h3>
                <a href="{{ route('admin.inquiries.index') }}" class="text-sm font-medium text-[#193670] hover:underline">View all</a>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse ($recentInquiries as $inquiry)
                    <li class="flex items-center justify-between gap-4 px-5 py-4">
                        <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="min-w-0 flex-1 hover:opacity-80">
                            <p class="truncate text-sm font-medium text-gray-900">{{ $inquiry->name ?? 'Unnamed' }}</p>
                            <p class="truncate text-xs text-gray-500">{{ $inquiry->email ?? 'No email' }}</p>
                            @if ($inquiry->phone)
                                <p class="truncate text-xs text-gray-400">{{ $inquiry->phone }}</p>
                            @endif
                        </a>
                        <div class="flex flex-shrink-0 items-center gap-3">
                            @if ($inquiry->phone)
                                <a href="tel:{{ $inquiry->phone }}" title="Call {{ $inquiry->phone }}" class="text-gray-400 hover:text-[#193670]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $inquiry->phone) }}" target="_blank" rel="noopener" title="WhatsApp {{ $inquiry->phone }}" class="text-gray-400 hover:text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2c-5.52 0-10 4.48-10 10 0 1.77.46 3.45 1.27 4.9L2 22l5.25-1.38a9.96 9.96 0 0 0 4.79 1.22h.01c5.52 0 10-4.48 10-10s-4.48-10-10-10Zm0 18.17h-.01a8.3 8.3 0 0 1-4.24-1.16l-.3-.18-3.12.82.83-3.04-.2-.31a8.26 8.26 0 0 1-1.27-4.4c0-4.58 3.73-8.3 8.32-8.3 2.22 0 4.3.87 5.87 2.44a8.25 8.25 0 0 1 2.43 5.87c0 4.58-3.73 8.3-8.31 8.3Zm4.56-6.22c-.25-.12-1.47-.72-1.7-.8-.23-.09-.39-.12-.56.12-.17.25-.64.8-.78.96-.14.17-.29.19-.53.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.39-1.72-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.23.25-.86.84-.86 2.05 0 1.21.88 2.38 1 2.54.12.17 1.73 2.64 4.19 3.7.59.25 1.05.4 1.4.51.59.19 1.13.16 1.55.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.11-.23-.17-.48-.29Z"/></svg>
                                </a>
                            @endif
                        </div>
                        <span class="flex-shrink-0 text-xs text-gray-400">{{ $inquiry->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-gray-400">No inquiries yet.</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                <h3 class="text-sm font-semibold text-gray-900">Recent Contact Clicks</h3>
                <a href="{{ route('admin.contact-clicks.index') }}" class="text-sm font-medium text-[#193670] hover:underline">View all</a>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse ($recentClicks as $click)
                    <li class="flex items-center justify-between gap-4 px-5 py-4">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-gray-900">{{ $click->value ?? 'Unknown' }}</p>
                            <p class="truncate text-xs text-gray-500">{{ ucfirst($click->type ?? 'unknown') }} &middot; {{ $click->ip_address ?? '—' }}</p>
                        </div>
                        <span class="flex-shrink-0 text-xs text-gray-400">{{ $click->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-gray-400">No contact clicks yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
