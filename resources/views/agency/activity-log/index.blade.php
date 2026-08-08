@extends('layouts.agency')

@section('title', __('common.activity_log'))

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ __('common.activity_log') }}</h2>
        <p class="text-sm text-gray-500">{{ __('common.activity_log_agency_note') }}</p>
    </div>

    <div data-tabs>
        <div class="flex flex-wrap gap-1 border-b border-gray-200">
            <button type="button" data-tab-target="system" class="tab-link active">{{ __('common.system_activity') }}</button>
            <button type="button" data-tab-target="query" class="tab-link">{{ __('common.query_activity') }}</button>
        </div>

        <div data-tab-panel="system" class="mt-4">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.when') }}</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.who') }}</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.action') }}</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.details') }}</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.ip') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($systemLogs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $log->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="px-4 py-3 text-gray-900">{{ $log->actor->name ?? __('common.system') }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ str($log->action)->headline() }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $log->description }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $log->ip_address ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_activity_yet') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $systemLogs->links() }}
        </div>

        <div data-tab-panel="query" class="mt-4 hidden">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.when') }}</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.who') }}</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.query') }}</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.type') }}</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.details') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($queryLogs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $log->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="px-4 py-3 text-gray-900">{{ $log->user->name ?? __('common.system') }}</td>
                                    <td class="px-4 py-3 text-gray-600">
                                        @if ($log->inquiry)
                                            <a href="{{ route('agency.inquiries.show', $log->inquiry) }}" class="text-[#193670] hover:underline">{{ $log->inquiry->name ?? __('common.query_hash', ['id' => $log->inquiry_id]) }}</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ str($log->type)->headline() }}</td>
                                    <td class="px-4 py-3 text-gray-600">
                                        @if ($log->type === 'status_change')
                                            {{ str($log->old_value)->headline() }} &rarr; {{ str($log->new_value)->headline() }}
                                            @if ($log->note) &mdash; {{ $log->note }} @endif
                                        @elseif ($log->type === 'assignment')
                                            {{ $log->note }}: {{ $log->old_value }} &rarr; {{ $log->new_value }}
                                        @else
                                            {{ $log->note }}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_query_activity_yet') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $queryLogs->links() }}
        </div>
    </div>
</div>
@endsection
