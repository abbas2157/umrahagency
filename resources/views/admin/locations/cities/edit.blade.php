@extends('layouts.admin')

@section('title', 'Edit City')

@section('content')
<div class="max-w-lg">
    <a href="{{ route('admin.locations.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">&larr; Back to locations</a>
    <h2 class="mb-6 text-2xl font-bold text-gray-900">Edit City</h2>

    <form method="POST" action="{{ route('admin.locations.cities.update', $city) }}" class="space-y-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        <div>
            <label for="province_id" class="block text-sm font-medium text-gray-700">Province</label>
            <select id="province_id" name="province_id" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" {{ (int) old('province_id', $city->province_id) === $province->id ? 'selected' : '' }}>{{ $province->name }} ({{ $province->country->name ?? '—' }})</option>
                @endforeach
            </select>
            @error('province_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $city->name) }}" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $city->is_active) ? 'checked' : '' }}
                class="rounded border-gray-300 text-[#193670] focus:ring-[#193670]">
            <label for="is_active" class="text-sm text-gray-700">Active</label>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Save Changes</button>
            <a href="{{ route('admin.locations.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">Cancel</a>
        </div>
    </form>
</div>
@endsection
