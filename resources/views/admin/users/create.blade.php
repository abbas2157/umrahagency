@extends('layouts.admin')

@section('title', __('common.add_user'))

@section('content')
<div class="max-w-xl">
    <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ __('common.add_user') }}</h2>

    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('common.name') }}</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('common.email') }}</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <x-password-input name="password" :label="__('common.password')" />
            <x-password-input name="password_confirmation" :label="__('common.confirm_password')" />
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">{{ __('common.role') }}</label>
            <select id="role" name="role" required
                onchange="document.getElementById('agency-field').classList.toggle('hidden', this.value === 'super_admin')"
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                @foreach (['super_admin' => __('common.role_super_admin'), 'agency_admin' => __('common.role_agency_admin'), 'agent' => __('common.role_agent')] as $value => $label)
                    <option value="{{ $value }}" {{ old('role') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div id="agency-field" class="{{ old('role', 'agency_admin') === 'super_admin' ? 'hidden' : '' }}">
            <label for="agency_id" class="block text-sm font-medium text-gray-700">{{ __('common.agency') }}</label>
            <select id="agency_id" name="agency_id"
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                <option value="">{{ __('common.select_an_agency') }}</option>
                @foreach ($agencies as $agency)
                    <option value="{{ $agency->id }}" {{ (int) old('agency_id') === $agency->id ? 'selected' : '' }}>{{ $agency->name }}</option>
                @endforeach
            </select>
            @error('agency_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.create_user') }}</button>
            <a href="{{ route('admin.users.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">{{ __('common.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
