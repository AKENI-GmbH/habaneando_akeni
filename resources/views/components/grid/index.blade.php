@props(['cols' => '2'])


<div {{ $attributes->merge(['class' => "grid sm:grid-cols-1 xl:grid-cols-{$cols} gap-0 lg:gap-8"]) }}>
    {{ $slot }}
</div>
