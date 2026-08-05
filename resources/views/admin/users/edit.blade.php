@extends('layouts.admin')

@section('title', 'Edit User')

@php $isSelf = $user->is(auth()->user()); @endphp

@section('content')
<div class="max-w-xl">
    <h2 class="mb-6 text-2xl font-bold text-gray-900">Edit User</h2>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <x-password-input name="password" label="New Password" :required="false" placeholder="Leave blank to keep current" />
            <x-password-input name="password_confirmation" label="Confirm New Password" :required="false" />
        </div>

        @if ($isSelf)
            <input type="hidden" name="role" value="{{ $user->role }}">
            <input type="hidden" name="agency_id" value="{{ $user->agency_id }}">
            <div>
                <span class="block text-sm font-medium text-gray-700">Role</span>
                <p class="mt-1 text-sm text-gray-500">{{ str($user->role)->headline() }} — you can't change your own role.</p>
            </div>
        @else
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select id="role" name="role" required
                    onchange="document.getElementById('agency-field').classList.toggle('hidden', this.value === 'super_admin')"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                    @foreach (['super_admin' => 'Super Admin', 'agency_admin' => 'Agency Admin', 'agent' => 'Agent'] as $value => $label)
                        <option value="{{ $value }}" {{ old('role', $user->role) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div id="agency-field" class="{{ old('role', $user->role) === 'super_admin' ? 'hidden' : '' }}">
                <label for="agency_id" class="block text-sm font-medium text-gray-700">Agency</label>
                <select id="agency_id" name="agency_id"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                    <option value="">— Select an agency —</option>
                    @foreach ($agencies as $agency)
                        <option value="{{ $agency->id }}" {{ (int) old('agency_id', $user->agency_id) === $agency->id ? 'selected' : '' }}>{{ $agency->name }}</option>
                    @endforeach
                </select>
                @error('agency_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        @endif

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Save Changes</button>
            <a href="{{ route('admin.users.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">Cancel</a>
        </div>
    </form>
</div>
@endsection
