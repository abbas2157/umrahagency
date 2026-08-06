@extends('layouts.admin')

@section('title', 'Add Plan')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.plans.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">&larr; Back to plans</a>
    <h2 class="mb-6 text-2xl font-bold text-gray-900">Add Plan</h2>

    <form method="POST" action="{{ route('admin.plans.store') }}" class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf

        @include('admin.plans._form', ['plan' => null])

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Create Plan</button>
            <a href="{{ route('admin.plans.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">Cancel</a>
        </div>
    </form>
</div>
@endsection
