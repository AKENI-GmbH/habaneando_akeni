@props(['title', 'header', 'description' => null])

@php
    $header = $header ?? (object)[];
    $darkenedColor = darkenColor($header->overlayColor ?? "#b51a00", 50);
    $mediaType = $header->mediaType ?? 'image';
    $cover = $header->cover ?? 'default-cover.jpg';  // Provide a default cover image path
    $videoId = $header->videoId ?? '';
    $overlay = $header->overlay ?? false;
    $overlayColor = $header->overlayColor ?? '#b51a00';
    $overlayOpacity = ($header->overlayOpacity ?? 100) / 100;
    $textColor = $header->textColor ?? '#ffffff';
    $caption = $header->caption ?? false;
@endphp

<div class="relative overflow-hidden px-6 h-40 sm:h-130 lg:px-8">
    @if ($mediaType == 'image')
        <img src="{{ asset($cover) }}" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover">
    @else
        <div class="absolute inset-0 -z-10">
            <div class="aspect-w-16 aspect-h-9">
                <iframe
                    src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&controls=0&loop=1&playlist={{ $videoId }}"
                    frameborder="0" allowfullscreen class="absolute inset-0 w-full h-full"></iframe>
            </div>
        </div>
    @endif

    @if ($overlay)
        <div class="absolute inset-0"
            style="background: radial-gradient(circle, {{ $overlayColor }}, {{ $darkenedColor }}); opacity: {{ $overlayOpacity }};">
        </div>
    @else
        <div class="absolute inset-0 bg-transparent"></div>
    @endif

    @if ($caption)
    <div class="absolute inset-0 flex items-center justify-center z-30">
        <div class="text-center max-w-screen-md">
            <h2 class="text-4xl font-medium tracking-tight sm:text-6xl" style="color: {{ $textColor }}">
                {{ $title }}</h2>
            @if ($description)
                <p class="mt-6 text-lg leading-8 text-black bg-white/80 w-fit mx-auto px-5">{{ $description }}</p>
            @endif
        </div>
    </div>    
    @endif
</div>
