@extends('layouts.admin')

@section('title', 'Inquiries')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Inquiries</h2>
            <p class="text-sm text-gray-500">{{ $inquiries->total() }} total submissions from the website contact form.</p>
        </div>
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone..."
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670] sm:w-64">
            <button class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Search</button>
        </form>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Contact</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Route / Package</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Travelers</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Date</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($inquiries as $inquiry)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $inquiry->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                <div>{{ $inquiry->email ?? '—' }}</div>
                                <div class="text-gray-400">{{ $inquiry->phone ?? '—' }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                <div>{{ $inquiry->departure_airport ?? '—' }}</div>
                                <div class="text-gray-400">{{ $inquiry->hotel_category ?? '—' }} &middot; {{ $inquiry->duration ?? '—' }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $inquiry->travelers ?? '—' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $inquiry->created_at->format('d M Y, h:i A') }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">View</a>
                                    <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" onsubmit="return confirm('Delete this inquiry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-gray-400">No inquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $inquiries->links() }}
</div>
@endsection
