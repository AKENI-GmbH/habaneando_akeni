<section>

    <div class="relative h-screen">
        <img src="{{ asset('images/header.jpeg') }}" alt=""
            class="absolute inset-0 -z-10 h-full w-full object-cover">

        <div class="absolute inset-x-0 bottom-0 mx-auto max-w-2xl">
            <div class="text-center">
                <div class="icon-scroll inline-block">
                    <span>Runterscrollen</span>
                    <div></div>
                </div>
            </div>
        </div>
    </div>



    <div class="bg-zinc-100 px-6 py-24 sm:py-32 lg:px-8">
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
