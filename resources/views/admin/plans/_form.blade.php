@php
    $plan ??= null;
    $field = fn (string $key) => old($key, $plan?->{$key});
    $inputClass = 'mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]';
@endphp

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('common.plan_name') }}</label>
        <input type="text" id="name" name="name" value="{{ $field('name') }}" placeholder="{{ __('common.plan_name_placeholder') }}" required class="{{ $inputClass }}">
        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="slug" class="block text-sm font-medium text-gray-700">{{ __('common.slug') }}</label>
        <input type="text" id="slug" name="slug" value="{{ $field('slug') }}" required
            @if (is_null($plan))
                oninput="document.getElementById('slug').value = this.value.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
            @endif
            class="{{ $inputClass }}">
        @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700">{{ __('common.price_pkr') }}</label>
        <input type="number" id="price" name="price" value="{{ $field('price') }}" step="0.01" min="0" required class="{{ $inputClass }}">
        @error('price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="billing_cycle" class="block text-sm font-medium text-gray-700">{{ __('common.billing_cycle') }}</label>
        <select id="billing_cycle" name="billing_cycle" required class="{{ $inputClass }}">
            <option value="monthly" {{ $field('billing_cycle') === 'monthly' ? 'selected' : '' }}>{{ __('common.cycle_monthly') }}</option>
            <option value="yearly" {{ $field('billing_cycle') === 'yearly' ? 'selected' : '' }}>{{ __('common.cycle_yearly') }}</option>
        </select>
    </div>
    <div class="sm:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700">{{ __('common.description') }}</label>
        <textarea id="description" name="description" rows="3" placeholder="{{ __('common.plan_description_placeholder') }}" class="{{ $inputClass }}">{{ $field('description') }}</textarea>
    </div>
</div>
