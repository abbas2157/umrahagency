@props(['dark' => false])

<div {{ $attributes->merge(['class' => 'flex items-center gap-1 rounded-lg p-1 text-xs font-medium '.($dark ? 'bg-white/10' : 'bg-gray-100')]) }}>
    @foreach (['en' => 'EN', 'ur' => 'اردو'] as $code => $label)
        <form method="POST" action="{{ route('locale.update') }}">
            @csrf
            <input type="hidden" name="locale" value="{{ $code }}">
            <button type="submit" class="rounded-md px-2.5 py-1 transition
                {{ app()->getLocale() === $code
                    ? ($dark ? 'bg-white/20 text-white' : 'bg-white text-gray-900 shadow-sm')
                    : ($dark ? 'text-white/60 hover:text-white' : 'text-gray-500 hover:text-gray-700') }}">
                {{ $label }}
            </button>
        </form>
    @endforeach
</div>
