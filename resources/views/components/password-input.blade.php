@props([
    'name',
    'label',
    'required' => true,
    'placeholder' => null,
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="relative mt-1">
        <input type="password" id="{{ $name }}" name="{{ $name }}"
            @if ($required) required @endif
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            class="w-full rounded-lg border border-gray-300 px-3 py-2 pr-10 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]">
        <button type="button" data-toggle-password tabindex="-1" aria-label="Show password"
            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600">
            <svg data-icon="eye" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
            <svg data-icon="eye-off" xmlns="http://www.w3.org/2000/svg" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 11 7 11 7a13.16 13.16 0 0 1-1.67 2.68M6.61 6.61A13.52 13.52 0 0 0 1 12s4 7 11 7a9.74 9.74 0 0 0 5.39-1.61"/><path d="M1 1l22 22"/></svg>
        </button>
    </div>
    @error($name) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>
