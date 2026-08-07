@extends('layouts.agency')

@section('title', __('common.generate_payroll'))

@section('content')
<div class="max-w-md">
    <a href="{{ route('agency.payrolls.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">&larr; {{ __('common.back_to_payrolls') }}</a>
    <h2 class="mb-2 text-2xl font-bold text-gray-900">{{ __('common.generate_payroll') }}</h2>
    <p class="mb-6 text-sm text-gray-500">{{ __('common.generate_payroll_hint') }}</p>

    <form method="POST" action="{{ route('agency.payrolls.store') }}" class="space-y-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf

        <div>
            <label for="period_month" class="block text-sm font-medium text-gray-700">{{ __('common.period') }}</label>
            <input type="month" id="period_month" name="period_month" value="{{ old('period_month', now()->format('Y-m')) }}" required
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
            @error('period_month') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.generate') }}</button>
            <a href="{{ route('agency.payrolls.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">{{ __('common.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
