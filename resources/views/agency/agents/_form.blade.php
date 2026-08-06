@php
    $agent ??= null;
    $field = fn (string $key) => old($key, $agent?->{$key});
    $inputClass = 'mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-[#193670] focus:outline-none focus:ring-1 focus:ring-[#193670]';
@endphp

<div>
    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
    <input type="text" id="name" name="name" value="{{ $field('name') }}" required class="{{ $inputClass }}">
    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="designation" class="block text-sm font-medium text-gray-700">Designation</label>
    <input type="text" id="designation" name="designation" value="{{ $field('designation') }}" placeholder="e.g. Umrah Consultant" class="{{ $inputClass }}">
</div>

<div>
    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
    <input type="email" id="email" name="email" value="{{ $field('email') }}" required class="{{ $inputClass }}">
    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    @if ($agent)
        <x-password-input name="password" label="New Password" :required="false" placeholder="Leave blank to keep current" />
        <x-password-input name="password_confirmation" label="Confirm New Password" :required="false" />
    @else
        <x-password-input name="password" label="Password" />
        <x-password-input name="password_confirmation" label="Confirm Password" />
    @endif
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
        <input type="text" id="phone" name="phone" value="{{ $field('phone') }}" placeholder="+923251212747" class="{{ $inputClass }}">
        @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="whatsapp" class="block text-sm font-medium text-gray-700">WhatsApp</label>
        <input type="text" id="whatsapp" name="whatsapp" value="{{ $field('whatsapp') }}" placeholder="923251212747" required class="{{ $inputClass }}">
        @error('whatsapp') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch</label>
    <select id="branch_id" name="branch_id" required class="{{ $inputClass }}">
        <option value="">Select a branch</option>
        @foreach ($branches as $branch)
            <option value="{{ $branch->id }}" {{ (int) $field('branch_id') === $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
        @endforeach
    </select>
    @error('branch_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="languages" class="block text-sm font-medium text-gray-700">Languages</label>
        <input type="text" id="languages" name="languages" value="{{ $field('languages') }}" placeholder="Urdu, English, Punjabi" class="{{ $inputClass }}">
    </div>
    <div>
        <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization</label>
        <input type="text" id="specialization" name="specialization" value="{{ $field('specialization') }}" placeholder="Hajj, Umrah, Visa" class="{{ $inputClass }}">
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Photo</label>

    @if ($field('photo'))
        <div class="mt-2 flex items-center gap-3">
            <img src="{{ $field('photo') }}" alt="Current photo" class="h-12 w-12 rounded-full border border-gray-200 bg-white object-cover">
            <span class="text-xs text-gray-400">Current photo — upload a file or paste a link below to replace it. Requires the agent's consent before it appears publicly.</span>
        </div>
    @endif

    @php
        $photoMode = old('photo_mode', $field('photo') ? 'link' : 'upload');
    @endphp
    <div class="mt-2 flex flex-wrap gap-2">
        <input type="radio" id="photo_mode_upload" name="photo_mode" value="upload" class="peer/upload sr-only" {{ $photoMode === 'upload' ? 'checked' : '' }}>
        <label for="photo_mode_upload" class="cursor-pointer rounded-md border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-500 transition peer-checked/upload:border-[#193670] peer-checked/upload:bg-[#193670] peer-checked/upload:text-white">Upload a file</label>

        <input type="radio" id="photo_mode_link" name="photo_mode" value="link" class="peer/link sr-only" {{ $photoMode === 'link' ? 'checked' : '' }}>
        <label for="photo_mode_link" class="cursor-pointer rounded-md border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-500 transition peer-checked/link:border-[#193670] peer-checked/link:bg-[#193670] peer-checked/link:text-white">Paste a link</label>

        <div class="hidden w-full peer-checked/upload:block">
            <input type="file" name="photo_file" accept="image/png,image/jpeg,image/webp" class="mt-1 block w-full text-sm text-gray-600 file:mr-3 file:rounded-md file:border-0 file:bg-gray-100 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-gray-700 hover:file:bg-gray-200">
            <p class="mt-1 text-xs text-gray-400">PNG, JPG or WebP, up to 2MB. Roughly square (~400×400).</p>
            @error('photo_file') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="hidden w-full peer-checked/link:block">
            <input type="text" name="photo" value="{{ $field('photo') }}" placeholder="https://.../agent.jpg" class="{{ $inputClass }}">
        </div>
    </div>
</div>
