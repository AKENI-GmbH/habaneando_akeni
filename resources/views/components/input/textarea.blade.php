@props([
    'leadingAddOn' => false,
])

<div class="flex rounded-md shadow-sm">
    @if ($leadingAddOn)
        <span
            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-neutral-300 bg-neutral-50 text-neutral-500 sm:text-sm">
            {{ $leadingAddOn }}
        </span>
    @endif

    <textarea rows="5"
        {{ $attributes->merge(['class' => 'block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-neutral-300 placeholder:text-neutral-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm sm:leading-6' . ($leadingAddOn ? ' rounded-none rounded-r-md' : '')]) }}></textarea>
</div>
