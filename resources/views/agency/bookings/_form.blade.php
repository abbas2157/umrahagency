@php
    $booking ??= null;
    $field = fn (string $key) => old($key, $booking?->{$key});
    $inputClass = 'mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]';
@endphp

@if (! $booking && isset($inquiries))
    <div>
        <label for="inquiry_id" class="block text-sm font-medium text-gray-700">{{ __('common.linked_inquiry') }}</label>
        <select id="inquiry_id" name="inquiry_id" class="{{ $inputClass }}">
            <option value="">{{ __('common.no_linked_inquiry') }}</option>
            @foreach ($inquiries as $inquiry)
                <option value="{{ $inquiry->id }}" {{ (int) $field('inquiry_id') === $inquiry->id || (isset($selectedInquiry) && $selectedInquiry?->id === $inquiry->id) ? 'selected' : '' }}>
                    #{{ $inquiry->id }} — {{ $inquiry->name }} ({{ $inquiry->departure_airport }})
                </option>
            @endforeach
        </select>
        @error('inquiry_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
@endif

@if (auth()->user()->isAgencyAdmin())
    <div>
        <label for="agent_id" class="block text-sm font-medium text-gray-700">{{ __('common.assigned_agent') }}</label>
        <select id="agent_id" name="agent_id" class="{{ $inputClass }}">
            <option value="">{{ __('common.unassigned') }}</option>
            @foreach ($agents as $agent)
                <option value="{{ $agent->id }}" {{ (int) $field('agent_id') === $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
            @endforeach
        </select>
        @error('agent_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
@endif

<div>
    <label for="package_tier" class="block text-sm font-medium text-gray-700">{{ __('common.package_tier') }}</label>
    <select id="package_tier" name="package_tier" required class="{{ $inputClass }}">
        @foreach (\App\Http\Controllers\Agency\BookingController::TIERS as $tier)
            <option value="{{ $tier }}" {{ $field('package_tier') === $tier ? 'selected' : '' }}>{{ __('common.tier_'.$tier) }}</option>
        @endforeach
    </select>
    @error('package_tier') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="total_price" class="block text-sm font-medium text-gray-700">{{ __('common.total_price_pkr') }}</label>
        <input type="number" step="0.01" min="0" id="total_price" name="total_price" value="{{ $field('total_price') }}" required class="{{ $inputClass }}">
        @error('total_price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="cost_price" class="block text-sm font-medium text-gray-700">{{ __('common.cost_price_pkr') }}</label>
        <input type="number" step="0.01" min="0" id="cost_price" name="cost_price" value="{{ $field('cost_price') }}" placeholder="{{ __('common.cost_price_hint') }}" class="{{ $inputClass }}">
        <p class="mt-1 text-xs text-gray-400">{{ __('common.cost_price_hint') }}</p>
        @error('cost_price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label for="booked_at" class="block text-sm font-medium text-gray-700">{{ __('common.booked_at') }}</label>
    <input type="date" id="booked_at" name="booked_at" value="{{ $field('booked_at') ? \Illuminate\Support\Carbon::parse($field('booked_at'))->format('Y-m-d') : now()->format('Y-m-d') }}" required class="{{ $inputClass }}">
    @error('booked_at') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>
