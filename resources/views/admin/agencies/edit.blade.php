@extends('layouts.admin')

@section('title', __('common.edit_agency'))

@section('content')
<div class="max-w-8xl">
    <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ __('common.edit_agency') }}</h2>

    <form method="POST" action="{{ route('admin.agencies.update', $agency) }}" enctype="multipart/form-data" class="space-y-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        @include('admin.agencies._form')

        <p class="text-xs text-gray-400">{{ __('common.deactivating_agency_note') }}</p>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.save_changes') }}</button>
            <a href="{{ route('admin.agencies.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">{{ __('common.cancel') }}</a>
        </div>
    </form>
</div>
@endsection
