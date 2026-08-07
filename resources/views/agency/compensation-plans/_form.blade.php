@php
    $plan ??= null;
    $field = fn (string $key) => old($key, $plan?->{$key});
    $tierRates = old('tier_rates', $plan?->tier_rates ?? []);
    $inputClass = 'mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]';
@endphp

<div>
    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('common.plan_name') }}</label>
    <input type="text" id="name" name="name" value="{{ $field('name') }}" required class="{{ $inputClass }}">
    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="type" class="block text-sm font-medium text-gray-700">{{ __('common.compensation_type') }}</label>
    <select id="type" name="type" required class="{{ $inputClass }}" onchange="umrahToggleCompFields()">
        <option value="salary" {{ $field('type') === 'salary' ? 'selected' : '' }}>{{ __('common.comp_type_salary') }}</option>
        <option value="commission" {{ $field('type') === 'commission' ? 'selected' : '' }}>{{ __('common.comp_type_commission') }}</option>
        <option value="salary_commission" {{ $field('type') === 'salary_commission' || ! $field('type') ? 'selected' : '' }}>{{ __('common.comp_type_salary_commission') }}</option>
    </select>
</div>

<div id="comp-base-salary-field">
    <label for="base_salary" class="block text-sm font-medium text-gray-700">{{ __('common.base_salary_pkr') }}</label>
    <input type="number" step="0.01" min="0" id="base_salary" name="base_salary" value="{{ $field('base_salary') ?? 0 }}" class="{{ $inputClass }}">
    @error('base_salary') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div id="comp-commission-fields" class="space-y-4 rounded-lg border border-gray-100 bg-gray-50 p-4">
    <div>
        <label for="commission_type" class="block text-sm font-medium text-gray-700">{{ __('common.commission_type') }}</label>
        <select id="commission_type" name="commission_type" class="{{ $inputClass }}" onchange="umrahToggleCompFields()">
            <option value="percent_sale" {{ $field('commission_type') === 'percent_sale' || ! $field('commission_type') ? 'selected' : '' }}>{{ __('common.commission_type_percent_sale') }}</option>
            <option value="percent_margin" {{ $field('commission_type') === 'percent_margin' ? 'selected' : '' }}>{{ __('common.commission_type_percent_margin') }}</option>
            <option value="fixed_per_tier" {{ $field('commission_type') === 'fixed_per_tier' ? 'selected' : '' }}>{{ __('common.commission_type_fixed_per_tier') }}</option>
        </select>
        @error('commission_type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div id="comp-rate-field">
        <label for="commission_rate" class="block text-sm font-medium text-gray-700">{{ __('common.commission_rate_percent') }}</label>
        <input type="number" step="0.01" min="0" max="100" id="commission_rate" name="commission_rate" value="{{ $field('commission_rate') }}" class="{{ $inputClass }}">
        <p class="mt-1 text-xs text-gray-400">{{ __('common.commission_rate_hint') }}</p>
        @error('commission_rate') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div id="comp-tier-fields">
        <label class="block text-sm font-medium text-gray-700">{{ __('common.tier_rates_pkr') }}</label>
        <p class="mt-1 text-xs text-gray-400">{{ __('common.tier_rates_hint') }}</p>
        <div class="mt-2 grid grid-cols-2 gap-3">
            @foreach (\App\Http\Controllers\Agency\BookingController::TIERS as $tier)
                <div>
                    <label for="tier_rates_{{ $tier }}" class="block text-xs text-gray-500">{{ __('common.tier_'.$tier) }}</label>
                    <input type="number" step="0.01" min="0" id="tier_rates_{{ $tier }}" name="tier_rates[{{ $tier }}]" value="{{ $tierRates[$tier] ?? '' }}" class="{{ $inputClass }}">
                </div>
            @endforeach
        </div>
        @error('tier_rates') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<script>
    function umrahToggleCompFields() {
        const type = document.getElementById('type').value;
        const commissionType = document.getElementById('commission_type').value;

        document.getElementById('comp-base-salary-field').style.display = (type === 'salary' || type === 'salary_commission') ? '' : 'none';
        document.getElementById('comp-commission-fields').style.display = (type === 'commission' || type === 'salary_commission') ? '' : 'none';
        document.getElementById('comp-rate-field').style.display = commissionType === 'fixed_per_tier' ? 'none' : '';
        document.getElementById('comp-tier-fields').style.display = commissionType === 'fixed_per_tier' ? '' : 'none';
    }

    document.addEventListener('DOMContentLoaded', umrahToggleCompFields);
</script>
