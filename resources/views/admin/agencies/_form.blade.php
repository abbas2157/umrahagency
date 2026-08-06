@php
    $agency ??= null;
    $field = fn (string $key) => old($key, $agency?->{$key});
@endphp

@php
    $inputClass = 'mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]';
    $sections = [
        'identity' => 'Identity',
        'phone' => 'Phone & Messaging',
        'email' => 'Email',
        'address' => 'Address',
        'hours' => 'Opening Hours',
        'licensing' => 'Licensing & Trust',
        'social' => 'Social Profiles',
        'service' => 'Service & Operations',
        'coverage' => 'Coverage',
    ];

    if (is_null($agency)) {
        $sections['first_login'] = 'First Login';
    }
@endphp

<div data-tabs data-active-step="identity" class="lg:flex lg:items-start lg:gap-8">
    <div class="mb-6 lg:mb-0 lg:w-64 lg:flex-shrink-0">
        @if ($agency)
            <div class="mb-4 rounded-lg border border-gray-200 bg-gray-50 p-4">
                <div class="mb-2 flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Profile completion</span>
                    <span class="text-sm font-bold text-[#193670]">{{ $agency->completionPercentage() }}%</span>
                </div>
                <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200">
                    <div class="h-full rounded-full bg-green-500 transition-all duration-300" style="width: {{ $agency->completionPercentage() }}%"></div>
                </div>
                <p class="mt-2 text-xs text-gray-400">How much of the profile below has real data — not how far you've clicked through it.</p>
            </div>
        @endif

        <div class="flex gap-2 overflow-x-auto pb-2 lg:flex-col lg:overflow-visible lg:pb-0">
            @foreach ($sections as $key => $label)
                <button type="button" data-tab-target="{{ $key }}" data-step-label="{{ $label }}"
                    class="step-pill lg:w-full {{ $loop->first ? 'active' : '' }} {{ ($agency && $agency->isSectionComplete($key)) ? 'done' : '' }}">
                    <span class="step-pill-number">{{ $loop->iteration }}</span>
                    <span class="flex-1 text-left">{{ $label }}</span>
                    @if ($agency && $agency->isSectionComplete($key))
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    @endif
                </button>
            @endforeach
        </div>
    </div>

    <div class="min-w-0 flex-1">
        <div class="mb-4 flex items-center justify-between border-b border-gray-100 pb-3">
            <p data-step-heading class="text-sm font-semibold text-gray-900">Step 1 of {{ count($sections) }} — Identity</p>
            <p class="hidden text-xs text-gray-400 sm:block">Jump to any section on the left, or use Back / Next below</p>
        </div>

        <div data-tab-panel="identity" class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Brand name</label>
                <input type="text" id="name" name="name" value="{{ $field('name') }}" required class="{{ $inputClass }}">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <input type="text" id="slug" name="slug" value="{{ $field('slug') }}" required
                    @if (is_null($agency))
                        oninput="document.getElementById('slug').value = this.value.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
                    @endif
                    class="{{ $inputClass }}">
                @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="legal_name" class="block text-sm font-medium text-gray-700">Legal registered name</label>
                <input type="text" id="legal_name" name="legal_name" value="{{ $field('legal_name') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="founded_year" class="block text-sm font-medium text-gray-700">Founded (year)</label>
                <input type="text" id="founded_year" name="founded_year" value="{{ $field('founded_year') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="owner_name" class="block text-sm font-medium text-gray-700">Owner / CEO name</label>
                <input type="text" id="owner_name" name="owner_name" value="{{ $field('owner_name') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="tagline" class="block text-sm font-medium text-gray-700">Tagline</label>
                <input type="text" id="tagline" name="tagline" value="{{ $field('tagline') }}" class="{{ $inputClass }}">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Logo</label>

                @if ($field('logo_path'))
                    <div class="mt-2 flex items-center gap-3">
                        <img src="{{ $field('logo_path') }}" alt="Current logo" class="h-12 w-12 rounded border border-gray-200 bg-white object-contain">
                        <span class="text-xs text-gray-400">Current logo — upload a file or paste a different link below to replace it.</span>
                    </div>
                @endif

                @php
                    $logoMode = old('logo_mode', $field('logo_path') ? 'link' : 'upload');
                @endphp
                <div class="mt-2 flex flex-wrap gap-2">
                    <input type="radio" id="logo_mode_upload" name="logo_mode" value="upload" class="peer/upload sr-only" {{ $logoMode === 'upload' ? 'checked' : '' }}>
                    <label for="logo_mode_upload" class="cursor-pointer rounded-md border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-500 transition peer-checked/upload:border-[#193670] peer-checked/upload:bg-[#193670] peer-checked/upload:text-white">Upload a file</label>

                    <input type="radio" id="logo_mode_link" name="logo_mode" value="link" class="peer/link sr-only" {{ $logoMode === 'link' ? 'checked' : '' }}>
                    <label for="logo_mode_link" class="cursor-pointer rounded-md border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-500 transition peer-checked/link:border-[#193670] peer-checked/link:bg-[#193670] peer-checked/link:text-white">Paste a link</label>

                    <div class="hidden w-full peer-checked/upload:block">
                        <input type="file" name="logo_file" accept="image/png,image/jpeg,image/webp" class="mt-1 block w-full text-sm text-gray-600 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-gray-700 hover:file:bg-gray-200">
                        <p class="mt-1 text-xs text-gray-400">PNG, JPG or WebP, up to 2MB.</p>
                        @error('logo_file') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="hidden w-full peer-checked/link:block">
                        <input type="text" id="logo_path" name="logo_path" value="{{ $field('logo_path') }}" placeholder="https://.../logo.png" class="{{ $inputClass }}">
                    </div>
                </div>
            </div>
        </div>

        <div data-tab-panel="phone" class="mt-4 hidden grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="phone_local" class="block text-sm font-medium text-gray-700">Primary phone (local)</label>
                <input type="text" id="phone_local" name="phone_local" value="{{ $field('phone_local') }}" placeholder="0325 121 2747" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="phone_e164" class="block text-sm font-medium text-gray-700">Primary phone (E.164)</label>
                <input type="text" id="phone_e164" name="phone_e164" value="{{ $field('phone_e164') }}" placeholder="+923251212747" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="whatsapp" class="block text-sm font-medium text-gray-700">WhatsApp number (E.164, no + or leading 0)</label>
                <input type="text" id="whatsapp" name="whatsapp" value="{{ $field('whatsapp') }}" placeholder="923251212747" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="phone_secondary" class="block text-sm font-medium text-gray-700">Secondary phone</label>
                <input type="text" id="phone_secondary" name="phone_secondary" value="{{ $field('phone_secondary') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="landline" class="block text-sm font-medium text-gray-700">Landline</label>
                <input type="text" id="landline" name="landline" value="{{ $field('landline') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="best_hours_to_call" class="block text-sm font-medium text-gray-700">Best hours to call</label>
                <input type="text" id="best_hours_to_call" name="best_hours_to_call" value="{{ $field('best_hours_to_call') }}" class="{{ $inputClass }}">
            </div>
        </div>

        <div data-tab-panel="email" class="mt-4 hidden grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="email_general" class="block text-sm font-medium text-gray-700">General enquiries</label>
                <input type="email" id="email_general" name="email_general" value="{{ $field('email_general') }}" class="{{ $inputClass }}">
                @error('email_general') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="email_bookings" class="block text-sm font-medium text-gray-700">Bookings</label>
                <input type="email" id="email_bookings" name="email_bookings" value="{{ $field('email_bookings') }}" class="{{ $inputClass }}">
                @error('email_bookings') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="email_support" class="block text-sm font-medium text-gray-700">Complaints / support</label>
                <input type="email" id="email_support" name="email_support" value="{{ $field('email_support') }}" class="{{ $inputClass }}">
                @error('email_support') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div data-tab-panel="address" class="mt-4 hidden grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="address_line" class="block text-sm font-medium text-gray-700">Street / building</label>
                <input type="text" id="address_line" name="address_line" value="{{ $field('address_line') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="address_area" class="block text-sm font-medium text-gray-700">Area / block</label>
                <input type="text" id="address_area" name="address_area" value="{{ $field('address_area') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                <input type="text" id="city" name="city" value="{{ $field('city') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
                <input type="text" id="province" name="province" value="{{ $field('province') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal code</label>
                <input type="text" id="postal_code" name="postal_code" value="{{ $field('postal_code') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                <input type="text" id="country" name="country" value="{{ $field('country') ?? 'Pakistan' }}" class="{{ $inputClass }}">
            </div>
            <div class="sm:col-span-2">
                <label for="maps_url" class="block text-sm font-medium text-gray-700">Google Maps share link</label>
                <input type="url" id="maps_url" name="maps_url" value="{{ $field('maps_url') }}" class="{{ $inputClass }}">
                @error('maps_url') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                <input type="text" id="latitude" name="latitude" value="{{ $field('latitude') }}" class="{{ $inputClass }}">
                @error('latitude') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                <input type="text" id="longitude" name="longitude" value="{{ $field('longitude') }}" class="{{ $inputClass }}">
                @error('longitude') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
                <label for="branch_offices" class="block text-sm font-medium text-gray-700">Branch offices</label>
                <textarea id="branch_offices" name="branch_offices" rows="3" placeholder="One per line: address — phone. Or write &quot;none&quot;." class="{{ $inputClass }}">{{ $field('branch_offices') }}</textarea>
            </div>
        </div>

        <div data-tab-panel="hours" class="mt-4 hidden grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="hours_mon_thu" class="block text-sm font-medium text-gray-700">Mon–Thu</label>
                <input type="text" id="hours_mon_thu" name="hours_mon_thu" value="{{ $field('hours_mon_thu') }}" placeholder="10:00–19:00" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="hours_friday" class="block text-sm font-medium text-gray-700">Friday</label>
                <input type="text" id="hours_friday" name="hours_friday" value="{{ $field('hours_friday') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="hours_saturday" class="block text-sm font-medium text-gray-700">Saturday</label>
                <input type="text" id="hours_saturday" name="hours_saturday" value="{{ $field('hours_saturday') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="hours_sunday" class="block text-sm font-medium text-gray-700">Sunday</label>
                <input type="text" id="hours_sunday" name="hours_sunday" value="{{ $field('hours_sunday') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="hours_public_holidays" class="block text-sm font-medium text-gray-700">Public holidays</label>
                <input type="text" id="hours_public_holidays" name="hours_public_holidays" value="{{ $field('hours_public_holidays') }}" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                <input type="text" id="timezone" name="timezone" value="{{ $field('timezone') ?? 'Asia/Karachi' }}" class="{{ $inputClass }}">
            </div>
        </div>

        <div data-tab-panel="licensing" class="mt-4 hidden">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="mora_license_no" class="block text-sm font-medium text-gray-700">MoRA Hajj/Umrah licence no.</label>
                    <input type="text" id="mora_license_no" name="mora_license_no" value="{{ $field('mora_license_no') }}" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="dts_license_no" class="block text-sm font-medium text-gray-700">DTS / travel agency licence no.</label>
                    <input type="text" id="dts_license_no" name="dts_license_no" value="{{ $field('dts_license_no') }}" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="iata_no" class="block text-sm font-medium text-gray-700">IATA accreditation no.</label>
                    <input type="text" id="iata_no" name="iata_no" value="{{ $field('iata_no') }}" placeholder="or &quot;not IATA accredited&quot;" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="ntn" class="block text-sm font-medium text-gray-700">NTN / tax registration</label>
                    <input type="text" id="ntn" name="ntn" value="{{ $field('ntn') }}" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="memberships" class="block text-sm font-medium text-gray-700">Chamber / association memberships</label>
                    <input type="text" id="memberships" name="memberships" value="{{ $field('memberships') }}" placeholder="e.g. TAAP, PATO" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="nusuk_registration" class="block text-sm font-medium text-gray-700">Saudi Nusuk Masar registration</label>
                    <input type="text" id="nusuk_registration" name="nusuk_registration" value="{{ $field('nusuk_registration') }}" class="{{ $inputClass }}">
                </div>
            </div>
            <p class="mt-2 text-xs text-amber-600">Only publish licences you actually hold — these matter more than design on a pilgrimage site.</p>
        </div>

        <div data-tab-panel="social" class="mt-4 hidden grid grid-cols-1 gap-4 sm:grid-cols-2">
            @foreach ([
                'social_facebook' => 'Facebook',
                'social_twitter' => 'Twitter / X',
                'social_instagram' => 'Instagram',
                'social_pinterest' => 'Pinterest',
                'social_youtube' => 'YouTube',
                'social_tiktok' => 'TikTok',
                'social_google_business' => 'Google Business Profile',
            ] as $key => $label)
                <div>
                    <label for="{{ $key }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                    <input type="url" id="{{ $key }}" name="{{ $key }}" value="{{ $field($key) }}" class="{{ $inputClass }}">
                    @error($key) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>

        <div data-tab-panel="service" class="mt-4 hidden grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="departure_airports" class="block text-sm font-medium text-gray-700">Departure airports served</label>
                <textarea id="departure_airports" name="departure_airports" rows="2" placeholder="Comma-separated: Lahore, Karachi, Islamabad, ..." class="{{ $inputClass }}">{{ $field('departure_airports') }}</textarea>
            </div>
            <div class="sm:col-span-2">
                <label for="services_offered" class="block text-sm font-medium text-gray-700">Services offered</label>
                <textarea id="services_offered" name="services_offered" rows="2" placeholder="Comma-separated: Hajj packages, Umrah packages, Umrah visa, ..." class="{{ $inputClass }}">{{ $field('services_offered') }}</textarea>
            </div>
            <div>
                <label for="languages_spoken" class="block text-sm font-medium text-gray-700">Languages spoken</label>
                <input type="text" id="languages_spoken" name="languages_spoken" value="{{ $field('languages_spoken') }}" placeholder="Urdu, English" class="{{ $inputClass }}">
            </div>
            <div>
                <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                <input type="text" id="currency" name="currency" value="{{ $field('currency') ?? 'PKR' }}" class="{{ $inputClass }}">
            </div>
            <div class="sm:col-span-2">
                <label for="payment_methods" class="block text-sm font-medium text-gray-700">Payment methods accepted</label>
                <input type="text" id="payment_methods" name="payment_methods" value="{{ $field('payment_methods') }}" placeholder="Bank transfer, cash, JazzCash, Easypaisa" class="{{ $inputClass }}">
            </div>
            <div class="sm:col-span-2">
                <label for="deposit_policy" class="block text-sm font-medium text-gray-700">Booking deposit policy</label>
                <textarea id="deposit_policy" name="deposit_policy" rows="2" class="{{ $inputClass }}">{{ $field('deposit_policy') }}</textarea>
            </div>
            <div class="sm:col-span-2">
                <label for="refund_policy_url" class="block text-sm font-medium text-gray-700">Refund / cancellation policy URL</label>
                <input type="text" id="refund_policy_url" name="refund_policy_url" value="{{ $field('refund_policy_url') }}" placeholder="/terms-conditions.html" class="{{ $inputClass }}">
            </div>
        </div>

        <div data-tab-panel="coverage" class="mt-4 hidden">
            <p class="mb-4 text-xs text-gray-500">Queries whose departure city matches one of these get auto-routed here. Leave none checked to receive nothing automatically — queries can still be hand-assigned as a fallback.</p>
            @php
                $selectedCityIds = old('cities', $agency?->cities->pluck('id')->toArray() ?? []);
                $citiesByProvince = ($cities ?? collect())->groupBy(fn ($city) => $city->province->name ?? 'Other');
            @endphp
            @forelse ($citiesByProvince as $provinceName => $provinceCities)
                <div class="mb-4">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-400">{{ $provinceName }}</p>
                    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                        @foreach ($provinceCities as $city)
                            <label class="flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" name="cities[]" value="{{ $city->id }}" {{ in_array($city->id, $selectedCityIds) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-[#193670] focus:ring-[#193670]">
                                {{ $city->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400">No cities exist yet — add some under Locations first.</p>
            @endforelse
            @error('cities') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        @if (is_null($agency))
            <div data-tab-panel="first_login" class="mt-4 hidden">
                <p class="mb-4 text-xs text-gray-500">Every agency needs at least one person who can log in and manage it. This creates its first Agency Admin — more Agents can be added afterward from the Users screen.</p>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="admin_name" class="block text-sm font-medium text-gray-700">Admin name</label>
                        <input type="text" id="admin_name" name="admin_name" value="{{ old('admin_name') }}" required class="{{ $inputClass }}">
                        @error('admin_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="admin_email" class="block text-sm font-medium text-gray-700">Admin email</label>
                        <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email') }}" required class="{{ $inputClass }}">
                        @error('admin_email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <x-password-input name="admin_password" label="Admin password" />
                    <x-password-input name="admin_password_confirmation" label="Confirm admin password" />
                </div>
            </div>
        @endif

        <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-5">
            <button type="button" data-step-nav="back" class="invisible rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                &larr; Back
            </button>
            <button type="button" data-step-nav="next" class="rounded-lg bg-[#193670] px-4 py-2 text-sm font-medium text-white hover:bg-[#122650]">
                Next &rarr;
            </button>
        </div>
    </div>
</div>

@unless ($hideActiveToggle ?? false)
    <div class="flex items-center gap-2 border-t border-gray-100 pt-5">
        <input type="checkbox" id="is_active" name="is_active" value="1" {{ $field('is_active') ?? true ? 'checked' : '' }}
            class="rounded border-gray-300 text-[#193670] focus:ring-[#193670]">
        <label for="is_active" class="text-sm text-gray-700">Active</label>
    </div>
@endunless
