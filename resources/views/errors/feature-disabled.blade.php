@extends('layouts.agency')

@section('title', __('common.feature_not_enabled'))

@section('content')
<div class="mx-auto max-w-md rounded-xl border border-gray-200 bg-white p-8 text-center shadow-sm">
    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
    </div>
    <h2 class="text-lg font-semibold text-gray-900">{{ __('common.feature_not_enabled') }}</h2>
    <p class="mt-2 text-sm text-gray-500">{{ __('common.feature_not_enabled_hint', ['feature' => $featureLabel]) }}</p>
    <a href="{{ route('agency.dashboard') }}" class="mt-6 inline-flex rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.back_to_dashboard') }}</a>
</div>
@endsection
