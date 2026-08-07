@php
    $agent ??= null;
    $field = fn (string $key) => old($key, $agent?->{$key});
    $inputClass = 'mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]';
@endphp

<div>
    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('common.name') }}</label>
    <input type="text" id="name" name="name" value="{{ $field('name') }}" required class="{{ $inputClass }}">
    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="designation" class="block text-sm font-medium text-gray-700">{{ __('common.designation') }}</label>
    <input type="text" id="designation" name="designation" value="{{ $field('designation') }}" placeholder="{{ __('common.designation_placeholder') }}" class="{{ $inputClass }}">
</div>

<div>
    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('common.email') }}</label>
    <input type="email" id="email" name="email" value="{{ $field('email') }}" required class="{{ $inputClass }}">
    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    @if ($agent)
        <x-password-input name="password" :label="__('common.new_password')" :required="false" :placeholder="__('common.leave_blank_password_hint')" />
        <x-password-input name="password_confirmation" :label="__('common.confirm_new_password')" :required="false" />
    @else
        <x-password-input name="password" :label="__('common.password')" />
        <x-password-input name="password_confirmation" :label="__('common.confirm_password')" />
    @endif
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('common.phone') }}</label>
        <input type="text" id="phone" name="phone" value="{{ $field('phone') }}" placeholder="{{ __('common.phone_optional_placeholder') }}" class="{{ $inputClass }}">
        @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="whatsapp" class="block text-sm font-medium text-gray-700">{{ __('common.whatsapp') }}</label>
        <input type="text" id="whatsapp" name="whatsapp" value="{{ $field('whatsapp') }}" placeholder="923251212747" required class="{{ $inputClass }}">
        @error('whatsapp') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label for="branch_id" class="block text-sm font-medium text-gray-700">{{ __('common.branch') }}</label>
    <select id="branch_id" name="branch_id" required class="{{ $inputClass }}">
        <option value="">{{ __('common.select_a_branch') }}</option>
        @foreach ($branches as $branch)
            <option value="{{ $branch->id }}" {{ (int) $field('branch_id') === $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
        @endforeach
    </select>
    @error('branch_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="languages" class="block text-sm font-medium text-gray-700">{{ __('common.languages') }}</label>
        <input type="text" id="languages" name="languages" value="{{ $field('languages') }}" placeholder="{{ __('common.languages_placeholder') }}" class="{{ $inputClass }}">
    </div>
    <div>
        <label for="specialization" class="block text-sm font-medium text-gray-700">{{ __('common.specialization') }}</label>
        <input type="text" id="specialization" name="specialization" value="{{ $field('specialization') }}" placeholder="{{ __('common.specialization_placeholder') }}" class="{{ $inputClass }}">
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">{{ __('common.photo') }}</label>

    @if ($field('photo'))
        <div class="mt-2 flex items-center gap-3">
            <img src="{{ $field('photo') }}" alt="{{ __('common.current_photo') }}" class="h-12 w-12 rounded-full border border-gray-200 bg-white object-cover">
            <span class="text-xs text-gray-400">{{ __('common.current_photo_note') }}</span>
        </div>
    @endif

    @php
        $photoMode = old('photo_mode', $field('photo') ? 'link' : 'upload');
    @endphp
    <div class="mt-2 flex flex-wrap gap-2">
        <input type="radio" id="photo_mode_upload" name="photo_mode" value="upload" class="peer/upload sr-only" {{ $photoMode === 'upload' ? 'checked' : '' }}>
        <label for="photo_mode_upload" class="cursor-pointer rounded-md border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-500 transition peer-checked/upload:border-[#193670] peer-checked/upload:bg-[#193670] peer-checked/upload:text-white">{{ __('common.upload_a_file') }}</label>

        <input type="radio" id="photo_mode_link" name="photo_mode" value="link" class="peer/link sr-only" {{ $photoMode === 'link' ? 'checked' : '' }}>
        <label for="photo_mode_link" class="cursor-pointer rounded-md border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-500 transition peer-checked/link:border-[#193670] peer-checked/link:bg-[#193670] peer-checked/link:text-white">{{ __('common.paste_a_link') }}</label>

        <div class="hidden w-full peer-checked/upload:block">
            <input type="file" name="photo_file" accept="image/png,image/jpeg,image/webp" class="mt-1 block w-full text-sm text-gray-600 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-gray-700 hover:file:bg-gray-200">
            <p class="mt-1 text-xs text-gray-400">{{ __('common.photo_upload_hint') }}</p>
            @error('photo_file') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="hidden w-full peer-checked/link:block">
            <input type="text" name="photo" value="{{ $field('photo') }}" placeholder="https://.../agent.jpg" class="{{ $inputClass }}">
        </div>
    </div>
</div>
