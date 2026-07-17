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
                    <li class="px-5 py-4">
                        <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="flex items-center justify-between gap-4 hover:opacity-80">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-gray-900">{{ $inquiry->name ?? 'Unnamed' }}</p>
                                <p class="truncate text-xs text-gray-500">{{ $inquiry->email ?? $inquiry->phone ?? 'No contact info' }}</p>
                            </div>
                            <span class="flex-shrink-0 text-xs text-gray-400">{{ $inquiry->created_at->diffForHumans() }}</span>
                        </a>
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
