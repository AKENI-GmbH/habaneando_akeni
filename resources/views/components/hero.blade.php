@props(['title', 'header', 'description' => null])

@php
    $darkenedColor = darkenColor($header->overlayColor, 50);
@endphp

<div class="relative overflow-hidden px-6 h-40 sm:h-130 lg:px-8">
    @if ($header->mediaType == 'image')
        <img src="{{ asset($header->cover) }}" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover">
    @else
        <div class="absolute inset-0 -z-10">
            <div class="aspect-w-16 aspect-h-9">
                <iframe
                    src="https://www.youtube.com/embed/{{ $header->videoId }}?autoplay=1&mute=1&controls=0&loop=1&playlist={{ $header->videoId }}"
                    frameborder="0" allowfullscreen class="absolute inset-0 w-full h-full"></iframe>
            </div>
        </div>
    @endif

    @if ($header->overlay)
        @php
            $opacity = $header->overlayOpacity / 100;
        @endphp
        <div class="absolute inset-0"
            style="background: radial-gradient(circle, {{ $header->overlayColor }}, {{ $darkenedColor }}); opacity: {{ $opacity }};">
        </div>
    @else
        <div class="absolute inset-0 bg-transparent"></div>
    @endif

    @if ($header->caption)
    <div class="absolute inset-0 flex items-center justify-center z-30">
        <div class="text-center max-w-screen-md">
            <h2 class="text-4xl font-medium tracking-tight sm:text-6xl" style="color: {{ $header->textColor }}">
                {{ $title }}</h2>
            @if ($description)
                <p class="mt-6 text-lg leading-8 text-black bg-white/80 w-fit mx-auto px-5">{{ $description }}</p>
            @endif
        </div>
    </div>    
    @endif
</div>
