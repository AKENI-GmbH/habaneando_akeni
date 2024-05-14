@props(['event'])

<article class="flex flex-col items-start justify-between relative">
    <div class="bg-red-600 absolute z-10 text-white -top-2 -left-2 px-4 py-1 text-center">
        <span class="block text-2xl font-extrabold">{{ Carbon\Carbon::parse($event->date_from)->format('d') }}</span>
        <span
            class="block text-lg font-medium uppercase">{{ Carbon\Carbon::parse($event->date_from)->format('M') }}</span>
    </div>
    <div class="relative w-full">
        <img src="{{ $event->thumbnail }}" alt=""
            class="aspect-[16/9] w-full  bg-neutral-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
        <div class="absolute inset-0  ring-1 ring-inset ring-gray-900/10"></div>
    </div>
    <div class="w-full">
        <div class="mt-2 flex items-center gap-x-4 text-sm">
            <x-icons.calendar class="text-red-700 h-4 w-4 -mr-2" />
            <time datetime="{{ $event->date_from }}"
                class="text-neutral-500">{{ Carbon\Carbon::parse($event->date_from)->format('D, d.M ') }}
                -
                {{ Carbon\Carbon::parse($event->time_from)->format('H:i') }}-{{ Carbon\Carbon::parse($event->time_to)->format('H:i') }}Uhr</time>

            <x-icons.pin class="text-red-700 h-4 w-4 -mr-5" />
            <span class="relative z-10 rounded-full bg-neutral-50 px-3 py-1.5 text-neutral-600">
                {{ $event->location->city }}, {{ $event->location->address }},
                {{ $event->location->zip }}
            </span>
        </div>
        <div class="group relative">
            <h3 class="mt-3 text-xl font-semibold leading-6 text-neutral-900 group-hover:text-neutral-600">
                <a href="{{ route('frontend.event.single', $event) }}">
                    <span class="absolute inset-0"></span>
                    {{ $event->name }}
                </a>
            </h3>
            @if ($event->short_text)
                <p
                    class="{{ $event->short_text ? 'mt-5' : 'mt-0' }} w-full line-clamp-3 text-sm leading-6 text-neutral-600">
                    {{ $event->short_text }}</p>
            @endif
        </div>
        <div class="relative mt-8 flex items-center gap-x-4">
            <a href="{{ route('frontend.event.single', $event) }}"
                class="ml-auto right-0 w-50 bg-red-500 text-white px-4 py-2 underline:none">Mehr
                Info</a>
        </div>
    </div>
</article>
