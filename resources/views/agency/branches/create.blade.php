@extends('layouts.agency')

@section('title', __('common.add_branch'))

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('agency.branches.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">&larr; {{ __('common.back_to_branches') }}</a>
    <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ __('common.add_branch') }}</h2>

    <form method="POST" action="{{ route('agency.branches.store') }}" class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf

        @include('agency.branches._form', ['branch' => null])

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_branch') }}</button>
            <a href="{{ route('agency.branches.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">{{ __('common.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
