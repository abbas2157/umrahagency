@extends('layouts.admin')

@section('title', __('common.dashboard'))

@section('content')
<div class="space-y-8">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ __('common.welcome_back', ['name' => auth()->user()->name]) }}</h2>
        <p class="text-sm text-gray-500">{{ __('common.platform_overview') }}</p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">{{ __('common.total_inquiries') }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_inquiries'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">{{ __('common.today') }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['inquiries_today'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">{{ __('common.last_7_days') }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['inquiries_this_week'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">{{ __('common.contact_clicks') }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_contact_clicks'] }}</p>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="mb-3 text-sm font-medium text-gray-500">{{ __('common.status_breakdown') }}</p>
        <div class="flex flex-wrap gap-2">
            @php
                $statusColors = [
                    'new' => 'bg-blue-50 text-blue-700',
                    'contacted' => 'bg-yellow-50 text-yellow-700',
                    'quoted' => 'bg-purple-50 text-purple-700',
                    'booked' => 'bg-green-50 text-green-700',
                    'lost' => 'bg-gray-100 text-gray-500',
                    'junk' => 'bg-red-50 text-red-700',
                ];
            @endphp
            @foreach ($statusBreakdown as $status => $count)
                <div class="flex items-center gap-2 rounded-lg px-3 py-2 {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-500' }}">
                    <span class="text-lg font-bold">{{ $count }}</span>
                    <span class="text-xs font-medium">{{ __('common.status_'.$status) }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">{{ __('common.active_agencies') }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $agencyStats['active_agencies'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">{{ __('common.inactive_agencies') }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $agencyStats['inactive_agencies'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">{{ __('common.total_agents') }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $agencyStats['total_agents'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                <h3 class="text-sm font-semibold text-gray-900">{{ __('common.recent_inquiries') }}</h3>
                <a href="{{ route('admin.inquiries.index') }}" class="text-sm font-medium text-[#193670] hover:underline">{{ __('common.view_all') }}</a>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse ($recentInquiries as $inquiry)
                    <li class="flex items-center justify-between gap-4 px-5 py-4">
                        <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="min-w-0 flex-1 hover:opacity-80">
                            <p class="truncate text-sm font-medium text-gray-900">{{ $inquiry->name ?? __('common.unnamed') }}</p>
                            <p class="truncate text-xs text-gray-500">{{ $inquiry->email ?? __('common.no_email') }}</p>
                            @if ($inquiry->phone)
                                <p class="truncate text-xs text-gray-400">{{ $inquiry->phone }}</p>
                            @endif
                        </a>
                        <span class="flex-shrink-0 text-xs text-gray-400">{{ $inquiry->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-gray-400">{{ __('common.no_inquiries_yet') }}</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                <h3 class="text-sm font-semibold text-gray-900">{{ __('common.recent_activity') }}</h3>
                <a href="{{ route('admin.activity-log.index') }}" class="text-sm font-medium text-[#193670] hover:underline">{{ __('common.view_all') }}</a>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse ($recentActivity as $log)
                    <li class="px-5 py-4">
                        <p class="text-sm text-gray-900">
                            <span class="font-medium">{{ $log->actor->name ?? __('common.system') }}</span>
                            {{ $log->description }}
                        </p>
                        <span class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-gray-400">{{ __('common.no_activity_yet') }}</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                <h3 class="text-sm font-semibold text-gray-900">{{ __('common.recent_contact_clicks') }}</h3>
                <a href="{{ route('admin.contact-clicks.index') }}" class="text-sm font-medium text-[#193670] hover:underline">{{ __('common.view_all') }}</a>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse ($recentClicks as $click)
                    <li class="flex items-center justify-between gap-4 px-5 py-4">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-gray-900">{{ $click->value ?? __('common.unknown') }}</p>
                            <p class="truncate text-xs text-gray-500">{{ ucfirst($click->type ?? __('common.unknown')) }} &middot; {{ $click->ip_address ?? '—' }}</p>
                        </div>
                        <span class="flex-shrink-0 text-xs text-gray-400">{{ $click->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-gray-400">{{ __('common.no_contact_clicks_yet') }}</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
