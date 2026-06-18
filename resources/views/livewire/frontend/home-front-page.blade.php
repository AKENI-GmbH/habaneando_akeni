<section>

    <div class="relative min-h-screen">
        <div style="background: radial-gradient(circle, #b50314, #270001); opacity: 1;" class="absolute inset-0 -z-10 h-full w-full object-cover">
        </div>

        <div class="mx-auto grid min-h-screen max-w-7xl grid-cols-1 items-center gap-8 px-6 pb-28 pt-16 sm:py-20 lg:grid-cols-3 lg:px-8">
            <div class="flex justify-center lg:justify-start">
                <img src="{{ asset('images/header.png') }}" alt="" class="max-h-[70vh] w-full max-w-sm object-contain lg:max-w-2xl">
            </div>
            <div class="text-center lg:col-span-2">
                <div class="mx-auto max-w-3xl">
                    <h1 class="text-xl font-semibold leading-tight text-white sm:text-2xl lg:text-3xl">
                        Salsa & Bachata für Paare in Speyer –
                        <span class="mt-3 block text-lg font-normal leading-snug sm:text-xl lg:text-2xl">für Anfänger, ganz ohne Vorkenntnisse.</span>
                    </h1>
                    <a href="{{ route('frontend.course.info') }}" class="mt-8 inline-flex items-center justify-center rounded-md bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm hover:bg-neutral-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Wöchentliches Tanzprogramm</a>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-4 text-center sm:grid-cols-3">
                    <div class="rounded-md bg-white p-4 text-neutral-900 shadow-sm">
                        <h2 class="text-base font-semibold">Anfänger-Tanzkurse</h2>
                        <div class="my-3 border-t border-neutral-200"></div>
                        <p class="text-sm text-neutral-700">Wähle deinen Rhytmus</p>
                        <div class="my-3 border-t border-neutral-200"></div>
                        <p class="text-sm font-medium">
                            <a class="hover:text-red-700" href="/tanzen/salsa">Salsa</a>
                            <span class="text-neutral-400"> | </span>
                            <a class="hover:text-red-700" href="/tanzen/bachata">Bachata</a>
                            <span class="text-neutral-400"> | </span>
                            <a class="hover:text-red-700" href="/tanzen/solo-tanz">Solo-Tanz</a>
                        </p>
                    </div>

                    <div class="rounded-md bg-white p-4 text-neutral-900 shadow-sm">
                        <h2 class="text-base font-semibold">Aktuelles</h2>
                        <div class="my-3 border-t border-neutral-200"></div>
                        <p class="text-sm font-medium">
                            <a class="hover:text-red-700" href="/workshop">Workshops</a>
                            <span class="text-neutral-400"> | </span>
                            <a class="hover:text-red-700" href="/events">Partys</a>
                        </p>
                    </div>

                    <div class="rounded-md bg-white p-4 text-neutral-900 shadow-sm">
                        <h2 class="text-base font-semibold">
                            <a class="hover:text-red-700" href="https://salsatanzreise.de/">Tanzreisen</a>
                        </h2>
                        <div class="my-3 border-t border-neutral-200"></div>
                        <p class="text-sm text-neutral-700">Tanzen lernen im Urlaub!</p>
                        <div class="my-3 border-t border-neutral-200"></div>
                        <a class="text-sm font-medium hover:text-red-700" href="https://salsatanzreise.de/">Jetzt entdecken →</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute inset-x-0 bottom-6 mx-auto max-w-2xl text-center">
            <a href="#next-section" class="inline-flex h-12 w-12 items-center justify-center rounded-full text-white transition hover:bg-white/10" aria-label="Zum nächsten Abschnitt scrollen">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25 12 15.75 4.5 8.25" />
                </svg>
            </a>
        </div>
    </div>



    <div id="next-section" class="bg-zinc-100 px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-2xl font-regular leading-7 uppercase">Erlebe Kuba Hautnah</p>
            <h2 class="mt-4 text-3xl font-normal uppercase tracking-tight sm:text-4xl sm:leading-tight">Salsa und
                Bachata Kurse in Speyer</h2>
            <p class="mt-4 text-lg leading-8 text-neutral-600">Tanzen ist das perfekte Gegengewicht zum Alltag. Diese
                karibischen Rhythmen stehen für Lebensfreude, Gemeinschaft, Sinnlichkeit.</p>

            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="{{ route('frontend.course.info') }}"
                    class="rounded-md bg-red-600 px-3.5 py-2.5 text-base font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Kursübersicht
                </a>
                {{-- <a href="#"
                    class="rounded-md bg-red-600 px-3.5 py-2.5 text-base font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Kursinfo
                </a> --}}
                <a href="{{ route('frontend.memebrship.create') }}"
                    class="text-base font-semibold leading-6 text-neutral-900">Zur Mitgliedschaftsinfo <span
                        aria-hidden="true">→</span></a>
            </div>
        </div>
    </div>


    <div class="bg-white py-12 sm:py-12">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">


                @foreach ($categories->sortBy('id') as $category)
                    <article class="flex flex-col items-start justify-between">
                        <div class="relative w-full">
                            <a href="{{route('frontend.course.category', $category->slug)}}">
                                <img src="{{ $category->header_image }}" alt=""
                                    class="aspect-[16/9] w-full rounded-2xl bg-neutral-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                                <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-neutral-900/10"></div>
                            </a>
                        </div>
                        <div class="max-w-xl">

                            <div class="group relative">
                                <h3
                                    class="mt-3 text-lg font-semibold leading-6 text-neutral-900 group-hover:text-neutral-600">
                                    <a href="{{route('frontend.course.category', $category->slug)}}">
                                        <span class="absolute inset-0"></span>
                                        {{ $category->name }}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm leading-6 text-neutral-600">{{ $category->short_text }}
                                </p>
                            </div>
                        </div> 
                    </article>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white py-12 sm:py-12">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">


                @foreach ($posts as $post)
                    <article class="flex flex-col items-start justify-between">
                        <div class="relative w-full">
                            <a href="{{ $post->url }}">
                                <img src="{{ $post->thumbnail }}" alt=""
                                    class="aspect-[16/9] w-full rounded-2xl bg-neutral-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                                <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-neutral-900/10"></div>
                            </a>
                        </div>
                        <div class="max-w-xl">

                            <div class="group relative">
                                <h3
                                    class="mt-3 text-lg font-semibold leading-6 text-neutral-900 group-hover:text-neutral-600">
                                    <a href="{{ $post->url }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $post->name }}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm leading-6 text-neutral-600">{{ $post->short_text }}
                                </p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>

    <livewire:frontend.contact-form />
</section>
