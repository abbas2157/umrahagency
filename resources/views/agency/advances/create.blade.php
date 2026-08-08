@extends('layouts.agency')

@section('title', __('common.issue_advance'))

@section('content')
<div class="max-w-xl">
    <a href="{{ route('agency.advances.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">&larr; {{ __('common.back_to_advances') }}</a>
    <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ __('common.issue_advance') }}</h2>

    <form method="POST" action="{{ route('agency.advances.store') }}" class="space-y-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf

        <div>
            <label for="agent_id" class="block text-sm font-medium text-gray-700">{{ __('common.assigned_agent') }}</label>
            <select id="agent_id" name="agent_id" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                <option value="">{{ __('common.select_an_agent') }}</option>
                @foreach ($agents as $agent)
                    <option value="{{ $agent->id }}" {{ (int) old('agent_id') === $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                @endforeach
            </select>
            @error('agent_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">{{ __('common.amount_pkr') }}</label>
                <input type="number" step="0.01" min="0.01" id="amount" name="amount" value="{{ old('amount') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                @error('amount') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="monthly_deduct" class="block text-sm font-medium text-gray-700">{{ __('common.monthly_deduct') }}</label>
                <input type="number" step="0.01" min="0.01" id="monthly_deduct" name="monthly_deduct" value="{{ old('monthly_deduct') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
                @error('monthly_deduct') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="reason" class="block text-sm font-medium text-gray-700">{{ __('common.reason_optional') }}</label>
            <input type="text" id="reason" name="reason" value="{{ old('reason') }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
        </div>

        <div>
            <label for="issued_on" class="block text-sm font-medium text-gray-700">{{ __('common.issued_on') }}</label>
            <input type="date" id="issued_on" name="issued_on" value="{{ old('issued_on', now()->format('Y-m-d')) }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            @error('issued_on') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.issue_advance') }}</button>
            <a href="{{ route('agency.advances.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">{{ __('common.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
