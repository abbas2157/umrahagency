@extends('layouts.admin')

@section('title', __('common.locations'))

@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ __('common.locations') }}</h2>
        <p class="text-sm text-gray-500">{!! __('common.locations_hierarchy_note') !!}</p>
    </div>

    <div data-tabs>
        <div class="flex flex-wrap gap-1 border-b border-gray-200">
            <button type="button" data-tab-target="countries" class="tab-link active">{{ __('common.countries') }} ({{ $countries->count() }})</button>
            <button type="button" data-tab-target="provinces" class="tab-link">{{ __('common.provinces') }} ({{ $provinces->count() }})</button>
            <button type="button" data-tab-target="cities" class="tab-link">{{ __('common.cities') }} ({{ $cities->count() }})</button>
            <button type="button" data-tab-target="areas" class="tab-link">{{ __('common.areas') }} ({{ $areas->count() }})</button>
        </div>

        <div data-tab-panel="countries" class="mt-4 space-y-4">
            <div class="flex justify-end">
                <a href="{{ route('admin.locations.countries.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_country') }}</a>
            </div>
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.name') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.iso2') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.provinces') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($countries as $country)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $country->name }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $country->iso2 ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $country->provinces_count }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $country->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $country->is_active ? __('common.active') : __('common.inactive') }}</span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.locations.countries.edit', $country) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">{{ __('common.edit') }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_countries_created_yet') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div data-tab-panel="provinces" class="mt-4 hidden space-y-4">
            <div class="flex justify-end">
                <a href="{{ route('admin.locations.provinces.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_province') }}</a>
            </div>
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.name') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.country') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.cities') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($provinces as $province)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $province->name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $province->country->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $province->cities_count }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $province->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $province->is_active ? __('common.active') : __('common.inactive') }}</span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.locations.provinces.edit', $province) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">{{ __('common.edit') }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_provinces_created_yet') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div data-tab-panel="cities" class="mt-4 hidden space-y-4">
            <div class="flex justify-end">
                <a href="{{ route('admin.locations.cities.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_city') }}</a>
            </div>
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.name') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.province') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.country') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.areas') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($cities as $city)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $city->name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $city->province->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $city->province->country->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $city->areas_count }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $city->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $city->is_active ? __('common.active') : __('common.inactive') }}</span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.locations.cities.edit', $city) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">{{ __('common.edit') }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_cities_created_yet') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div data-tab-panel="areas" class="mt-4 hidden space-y-4">
            <div class="flex justify-end">
                <a href="{{ route('admin.locations.areas.create') }}" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">{{ __('common.add_area') }}</a>
            </div>
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.name') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.city') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.province') }}</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600">{{ __('common.status') }}</th>
                            <th class="px-4 py-3 text-right font-semibold text-gray-600">{{ __('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($areas as $area)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $area->name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $area->city->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $area->city->province->name ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $area->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $area->is_active ? __('common.active') : __('common.inactive') }}</span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.locations.areas.edit', $area) }}" class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">{{ __('common.edit') }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">{{ __('common.no_areas_created_yet') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
