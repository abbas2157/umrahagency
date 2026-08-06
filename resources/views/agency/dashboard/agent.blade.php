@extends('layouts.agency')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h2>
        <p class="text-sm text-gray-500">Here's what's on your plate at {{ $agency->name }}.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                @if ($agency->logo_path)
                    <img src="{{ $agency->logo_path }}" alt="{{ $agency->name }}" class="h-12 w-12 flex-shrink-0 rounded-lg border border-gray-200 bg-white object-contain">
                @endif
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-500">My Agency</p>
                    <p class="truncate text-lg font-semibold text-gray-900">{{ $agency->name }}</p>
                </div>
                <span class="flex-shrink-0 rounded-full px-2.5 py-1 text-xs font-medium {{ $agency->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $agency->is_active ? 'Active' : 'Inactive' }}</span>
            </div>
            @php
                $agencyAddress = collect([$agency->address_line, $agency->address_area, $agency->city, $agency->province])->filter()->implode(', ');
            @endphp
            <dl class="mt-4 space-y-1.5 text-sm text-gray-600">
                @if ($agencyAddress)
                    <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Address</dt><dd>{{ $agencyAddress }}</dd></div>
                @endif
                @if ($agency->phone_local)
                    <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Phone</dt><dd>{{ $agency->phone_local }}</dd></div>
                @endif
                @if ($agency->landline)
                    <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Landline</dt><dd>{{ $agency->landline }}</dd></div>
                @endif
                @if ($agency->whatsapp)
                    <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">WhatsApp</dt><dd>{{ $agency->whatsapp }}</dd></div>
                @endif
                @if ($agency->email_general)
                    <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Email</dt><dd>{{ $agency->email_general }}</dd></div>
                @endif
                @if ($agency->maps_url)
                    <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Map</dt><dd><a href="{{ $agency->maps_url }}" target="_blank" rel="noopener" class="text-[#193670] hover:underline">View on Google Maps</a></dd></div>
                @endif
            </dl>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">My Branch</p>
            @if ($branch)
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $branch->name }}</p>
                <dl class="mt-4 space-y-1.5 text-sm text-gray-600">
                    @if ($branch->address_line || $branch->area || $branch->city)
                        <div class="flex gap-2">
                            <dt class="w-20 flex-shrink-0 text-gray-400">Address</dt>
                            <dd>{{ collect([$branch->address_line, $branch->area, $branch->city?->name])->filter()->implode(', ') }}</dd>
                        </div>
                    @endif
                    @if ($branch->phone)
                        <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Phone</dt><dd>{{ $branch->phone }}</dd></div>
                    @endif
                    @if ($branch->whatsapp)
                        <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">WhatsApp</dt><dd>{{ $branch->whatsapp }}</dd></div>
                    @endif
                    @if ($branch->email)
                        <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Email</dt><dd>{{ $branch->email }}</dd></div>
                    @endif
                    @if ($branch->hours)
                        <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Hours</dt><dd>{{ $branch->hours }}</dd></div>
                    @endif
                    @if ($branch->maps_url)
                        <div class="flex gap-2"><dt class="w-20 flex-shrink-0 text-gray-400">Map</dt><dd><a href="{{ $branch->maps_url }}" target="_blank" rel="noopener" class="text-[#193670] hover:underline">View on Google Maps</a></dd></div>
                    @endif
                </dl>
            @else
                <p class="mt-1 text-sm text-gray-400">You haven't been assigned to a branch yet — ask your agency admin.</p>
            @endif
        </div>
    </div>

    @if ($newSinceLastLogin > 0 || $needsFollowUpCount > 0)
        <div class="flex flex-col gap-3 rounded-xl border border-amber-200 bg-amber-50 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                <p class="text-sm font-medium text-amber-900">Needs your attention</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @if ($newSinceLastLogin > 0)
                    <a href="{{ route('agency.inquiries.index') }}" class="rounded-lg bg-white px-3 py-1.5 text-sm font-medium text-amber-800 shadow-sm hover:bg-amber-100">{{ $newSinceLastLogin }} new since your last login</a>
                @endif
                @if ($needsFollowUpCount > 0)
                    <a href="{{ route('agency.inquiries.index', ['needs_follow_up' => 1]) }}" class="rounded-lg bg-white px-3 py-1.5 text-sm font-medium text-amber-800 shadow-sm hover:bg-amber-100">{{ $needsFollowUpCount }} need follow-up</a>
                @endif
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">My Queries</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_inquiries'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Today</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['inquiries_today'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Last 7 Days</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['inquiries_this_week'] }}</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Resolved This Week</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $resolvedThisWeek }}</p>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="mb-3 text-sm font-medium text-gray-500">My Performance</p>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-5">
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $performance['total'] }}</p>
                <p class="text-xs text-gray-500">All-time assigned</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-green-700">{{ $performance['booked'] }}</p>
                <p class="text-xs text-gray-500">Booked</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-500">{{ $performance['lost'] }}</p>
                <p class="text-xs text-gray-500">Lost / Junk</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-blue-700">{{ $performance['conversion_rate'] }}%</p>
                <p class="text-xs text-gray-500">Conversion rate</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::formatResponseMinutes($performance['avg_response_minutes']) }}</p>
                <p class="text-xs text-gray-500">Avg. response time</p>
            </div>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="mb-3 text-sm font-medium text-gray-500">My Queries by Status</p>
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
                    <span class="text-xs font-medium">{{ str($status)->headline() }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <h3 class="text-sm font-semibold text-gray-900">Recent Queries</h3>
            <a href="{{ route('agency.inquiries.index') }}" class="text-sm font-medium text-[#193670] hover:underline">View all</a>
        </div>
        <ul class="divide-y divide-gray-100">
            @forelse ($recentInquiries as $inquiry)
                <li class="flex items-center justify-between gap-4 px-5 py-4">
                    <a href="{{ route('agency.inquiries.show', $inquiry) }}" class="min-w-0 flex-1 hover:opacity-80">
                        <p class="truncate text-sm font-medium text-gray-900">{{ $inquiry->name ?? 'Unnamed' }}</p>
                        <p class="truncate text-xs text-gray-500">{{ $inquiry->email ?? 'No email' }}</p>
                        @if ($inquiry->phone)
                            <p class="truncate text-xs text-gray-400">{{ $inquiry->phone }}</p>
                        @endif
                    </a>
                    <span class="flex-shrink-0 text-xs text-gray-400">{{ $inquiry->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li class="px-5 py-8 text-center text-sm text-gray-400">No queries assigned to you yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
