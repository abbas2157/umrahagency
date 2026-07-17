@extends('layouts.admin')

@section('title', 'Contact Clicks')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Contact Clicks</h2>
            <p class="text-sm text-gray-500">{{ $clicks->total() }} tracked clicks on phone/email links across the site.</p>
        </div>
        <form method="GET" class="flex flex-wrap gap-2">
            <select name="type" onchange="this.form.submit()"
                class="rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                <option value="">All types</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}" @selected(request('type') === $type)>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search value, page, IP..."
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670] sm:w-56">
            <button class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Search</button>
        </form>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Type</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Value</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Page</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">IP Address</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Date</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($clicks as $click)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $click->type === 'phone' ? 'bg-amber-50 text-amber-700' : 'bg-blue-50 text-blue-700' }}">
                                    {{ ucfirst($click->type ?? 'unknown') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-900">{{ $click->value ?? '—' }}</td>
                            <td class="max-w-xs truncate px-4 py-3 text-gray-500">{{ $click->page_url ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $click->ip_address ?? '—' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $click->created_at->format('d M Y, h:i A') }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('admin.contact-clicks.destroy', $click) }}" onsubmit="return confirm('Delete this record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-gray-400">No contact clicks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $clicks->links() }}
</div>
@endsection
