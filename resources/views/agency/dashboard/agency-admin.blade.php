@extends('layouts.agency')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="text-sm text-gray-500">Here's what's happening at {{ $agency->name }}.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('agency.agency-profile.edit') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Edit My Agency</a>
            <a href="{{ route('agency.agents.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Add Agent</a>
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

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-sm font-medium text-gray-500">Agency</p>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $agency->name }}</p>
            </div>
            <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $agency->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $agency->is_active ? 'Active' : 'Inactive' }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Agency Queries</p>
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
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="mb-3 text-sm font-medium text-gray-500">Status Breakdown</p>
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
            <h3 class="text-sm font-semibold text-gray-900">Agent Roster</h3>
            <a href="{{ route('agency.agents.performance') }}" class="text-sm font-medium text-[#193670] hover:underline">Full performance report</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Agent</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Assigned</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Booked</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Lost</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Conversion</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Avg. Response</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($agentRoster as $row)
                        <tr>
                            <td class="px-5 py-3 font-medium text-gray-900">{{ $row['agent']->name }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $row['total'] }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $row['booked'] }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $row['lost'] }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $row['conversion_rate'] }}%</td>
                            <td class="px-5 py-3 text-gray-600">{{ \App\Models\User::formatResponseMinutes($row['avg_response_minutes']) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-gray-400">No agents yet — <a href="{{ route('agency.agents.create') }}" class="text-[#193670] underline">add your first one</a>.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
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
                        </a>
                        <span class="flex-shrink-0 text-xs text-gray-400">{{ $inquiry->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-gray-400">No queries yet.</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                <h3 class="text-sm font-semibold text-gray-900">Recent Activity</h3>
                <a href="{{ route('agency.activity-log.index') }}" class="text-sm font-medium text-[#193670] hover:underline">View all</a>
            </div>
            <ul class="divide-y divide-gray-100">
                @forelse ($recentActivity as $log)
                    <li class="px-5 py-4">
                        <p class="text-sm text-gray-900">
                            <span class="font-medium">{{ $log->actor->name ?? 'System' }}</span>
                            {{ $log->description }}
                        </p>
                        <span class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="px-5 py-8 text-center text-sm text-gray-400">No activity yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
