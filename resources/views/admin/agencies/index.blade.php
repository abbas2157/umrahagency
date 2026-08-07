@extends('layouts.admin')

@section('title', __('common.agencies'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('common.agencies') }}</h2>
            <p class="text-sm text-gray-500">{{ __('common.total_count', ['count' => $agencies->total()]) }}</p>
        </div>
        <a href="{{ route('admin.agencies.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_agency') }}</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.agency') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.location') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.contact') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.branches_count') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.agents') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.queries') }}</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($agencies as $agency)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ $agency->name }}</div>
                                <div class="text-xs text-gray-400">{{ $agency->slug }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ collect([$agency->city, $agency->province])->filter()->implode(', ') ?: '—' }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                @if ($agency->phone_local || $agency->whatsapp)
                                    <div>{{ $agency->phone_local ?? '—' }}</div>
                                    <div class="mt-0.5 flex items-center gap-2 text-gray-400">
                                        @if ($agency->phone_e164)
                                            <a href="tel:{{ $agency->phone_e164 }}" title="Call {{ $agency->phone_e164 }}" class="text-gray-400 hover:text-[#193670]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
                                            </a>
                                        @endif
                                        @if ($agency->whatsapp)
                                            <a href="https://wa.me/{{ $agency->whatsapp }}" target="_blank" rel="noopener" title="WhatsApp {{ $agency->whatsapp }}" class="text-gray-400 hover:text-green-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2c-5.52 0-10 4.48-10 10 0 1.77.46 3.45 1.27 4.9L2 22l5.25-1.38a9.96 9.96 0 0 0 4.79 1.22h.01c5.52 0 10-4.48 10-10s-4.48-10-10-10Zm0 18.17h-.01a8.3 8.3 0 0 1-4.24-1.16l-.3-.18-3.12.82.83-3.04-.2-.31a8.26 8.26 0 0 1-1.27-4.4c0-4.58 3.73-8.3 8.32-8.3 2.22 0 4.3.87 5.87 2.44a8.25 8.25 0 0 1 2.43 5.87c0 4.58-3.73 8.3-8.31 8.3Zm4.56-6.22c-.25-.12-1.47-.72-1.7-.8-.23-.09-.39-.12-.56.12-.17.25-.64.8-.78.96-.14.17-.29.19-.53.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.39-1.72-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.23.25-.86.84-.86 2.05 0 1.21.88 2.38 1 2.54.12.17 1.73 2.64 4.19 3.7.59.25 1.05.4 1.4.51.59.19 1.13.16 1.55.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.11-.23-.17-.48-.29Z"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $agency->branches_count }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $agency->agents_count }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $agency->inquiries_count }}</td>
                            <td class="px-4 py-3">
                                @if ($agency->is_active)
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">{{ __('common.active') }}</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">{{ __('common.inactive') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.agencies.show', $agency) }}" class="rounded-md bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100">{{ __('common.view') }}</a>
                                    <a href="{{ route('admin.agencies.edit', $agency) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">{{ __('common.edit') }}</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_agencies_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $agencies->links() }}
</div>
@endsection
