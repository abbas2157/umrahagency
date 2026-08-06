@extends('layouts.agency')

@section('title', 'Branches')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Branches</h2>
            <p class="text-sm text-gray-500">{{ $branches->count() }} total. Every outlet this agency operates from.</p>
        </div>
        <a href="{{ route('agency.branches.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Add Branch</a>
    </div>

    @if ($errors->any())
        <div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Area / City</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Phone</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Agents</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($branches as $branch)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $branch->name }}
                                @if ($branch->is_main)
                                    <span class="ml-1 rounded-full bg-blue-50 px-1.5 py-0.5 text-xs font-medium text-blue-700">Main</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                <div>{{ $branch->area ?? '—' }}</div>
                                <div class="text-gray-400">{{ $branch->city?->name ?? '—' }}{{ $branch->city?->province ? ', '.$branch->city->province->name : '' }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $branch->phone }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $branch->agents->count() }}</td>
                            <td class="px-4 py-3">
                                @if ($branch->is_active)
                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">Active</span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('agency.branches.edit', $branch) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">Edit</a>
                                    @if ($branch->is_active)
                                        <form method="POST" action="{{ route('agency.branches.deactivate', $branch) }}" onsubmit="return confirm('Deactivate this branch?');">
                                            @csrf
                                            @method('PATCH')
                                            <button class="rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">Deactivate</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('agency.branches.activate', $branch) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="rounded-md bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-100">Activate</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-gray-400">No branches yet — add your first outlet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
