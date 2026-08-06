@extends('layouts.agency')

@section('title', 'My Agency')

@section('content')
<div class="max-w-8xl">
    <h2 class="mb-6 text-2xl font-bold text-gray-900">My Agency</h2>

    <form method="POST" action="{{ route('agency.agency-profile.update') }}" enctype="multipart/form-data" class="space-y-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        @include('admin.agencies._form', ['agency' => $agency, 'hideActiveToggle' => true])

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">Save Changes</button>
        </div>
    </form>
</div>
@endsection
