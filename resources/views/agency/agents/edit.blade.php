@extends('layouts.agency')

@section('title', 'Edit Agent')

@section('content')
<div class="max-w-xl">
    <a href="{{ route('agency.agents.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-medium text-[#193670] hover:underline">&larr; Back to agents</a>
    <h2 class="mb-6 text-2xl font-bold text-gray-900">Edit Agent</h2>

    <form method="POST" action="{{ route('agency.agents.update', $agent) }}" enctype="multipart/form-data" class="space-y-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        @include('agency.agents._form')

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Save Changes</button>
            <a href="{{ route('agency.agents.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100">Cancel</a>
        </div>
    </form>
</div>
@endsection
