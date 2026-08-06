@php
    $plan ??= null;
    $field = fn (string $key) => old($key, $plan?->{$key});
    $inputClass = 'mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]';
@endphp

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Plan name</label>
        <input type="text" id="name" name="name" value="{{ $field('name') }}" placeholder="e.g. Basic, Pro" required class="{{ $inputClass }}">
        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
        <input type="text" id="slug" name="slug" value="{{ $field('slug') }}" required
            @if (is_null($plan))
                oninput="document.getElementById('slug').value = this.value.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
            @endif
            class="{{ $inputClass }}">
        @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700">Price (PKR)</label>
        <input type="number" id="price" name="price" value="{{ $field('price') }}" step="0.01" min="0" required class="{{ $inputClass }}">
        @error('price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="billing_cycle" class="block text-sm font-medium text-gray-700">Billing cycle</label>
        <select id="billing_cycle" name="billing_cycle" required class="{{ $inputClass }}">
            <option value="monthly" {{ $field('billing_cycle') === 'monthly' ? 'selected' : '' }}>Monthly</option>
            <option value="yearly" {{ $field('billing_cycle') === 'yearly' ? 'selected' : '' }}>Yearly</option>
        </select>
    </div>
    <div class="sm:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea id="description" name="description" rows="3" placeholder="What this plan includes — for your own reference, not enforced anywhere yet." class="{{ $inputClass }}">{{ $field('description') }}</textarea>
    </div>
</div>
