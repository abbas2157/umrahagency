@php
    $branch ??= null;
    $field = fn (string $key) => old($key, $branch?->{$key});
    $inputClass = 'mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]';
    $citiesByProvince = $cities->groupBy(fn ($city) => $city->province->name ?? 'Other');
@endphp

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('common.branch_name') }}</label>
        <input type="text" id="name" name="name" value="{{ $field('name') }}" placeholder="{{ __('common.branch_name_placeholder') }}" required class="{{ $inputClass }}">
        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="city_id" class="block text-sm font-medium text-gray-700">{{ __('common.city') }}</label>
        <select id="city_id" name="city_id" required class="{{ $inputClass }}">
            <option value="">{{ __('common.select_a_city') }}</option>
            @foreach ($citiesByProvince as $provinceName => $provinceCities)
                <optgroup label="{{ $provinceName }}">
                    @foreach ($provinceCities as $city)
                        <option value="{{ $city->id }}" {{ (int) $field('city_id') === $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        @error('city_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="area" class="block text-sm font-medium text-gray-700">{{ __('common.area_block') }}</label>
        <input type="text" id="area" name="area" value="{{ $field('area') }}" class="{{ $inputClass }}">
    </div>

    <div class="sm:col-span-2">
        <label for="address_line" class="block text-sm font-medium text-gray-700">{{ __('common.street_building') }}</label>
        <input type="text" id="address_line" name="address_line" value="{{ $field('address_line') }}" placeholder="{{ __('common.office_address_placeholder') }}" required class="{{ $inputClass }}">
        @error('address_line') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="latitude" class="block text-sm font-medium text-gray-700">{{ __('common.latitude') }}</label>
        <input type="text" id="latitude" name="latitude" value="{{ $field('latitude') }}" placeholder="{{ __('common.from_google_maps') }}" class="{{ $inputClass }}">
        @error('latitude') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="longitude" class="block text-sm font-medium text-gray-700">{{ __('common.longitude') }}</label>
        <input type="text" id="longitude" name="longitude" value="{{ $field('longitude') }}" placeholder="{{ __('common.from_google_maps') }}" class="{{ $inputClass }}">
        @error('longitude') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('common.phone') }}</label>
        <input type="text" id="phone" name="phone" value="{{ $field('phone') }}" placeholder="+923251212747" required class="{{ $inputClass }}">
        <p class="mt-1 text-xs text-gray-400">{{ __('common.phone_e164_hint') }}</p>
        @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="whatsapp" class="block text-sm font-medium text-gray-700">{{ __('common.whatsapp') }}</label>
        <input type="text" id="whatsapp" name="whatsapp" value="{{ $field('whatsapp') }}" placeholder="923251212747" required class="{{ $inputClass }}">
        <p class="mt-1 text-xs text-gray-400">{{ __('common.whatsapp_digits_hint') }}</p>
        @error('whatsapp') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('common.email') }}</label>
        <input type="email" id="email" name="email" value="{{ $field('email') }}" required class="{{ $inputClass }}">
        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="hours" class="block text-sm font-medium text-gray-700">{{ __('common.hours') }}</label>
        <input type="text" id="hours" name="hours" value="{{ $field('hours') }}" placeholder="{{ __('common.hours_placeholder') }}" class="{{ $inputClass }}">
    </div>

    <div class="sm:col-span-2">
        <label for="maps_url" class="block text-sm font-medium text-gray-700">{{ __('common.google_maps_link') }}</label>
        <input type="url" id="maps_url" name="maps_url" value="{{ $field('maps_url') }}" class="{{ $inputClass }}">
        @error('maps_url') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-2 sm:col-span-2">
        <input type="checkbox" id="is_main" name="is_main" value="1" {{ $field('is_main') ? 'checked' : '' }} class="rounded border-gray-300 text-[#193670] focus:ring-[#193670]">
        <label for="is_main" class="text-sm text-gray-700">{{ __('common.is_main_branch_label') }}</label>
    </div>
</div>
