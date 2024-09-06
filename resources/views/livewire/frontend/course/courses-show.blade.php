<div>

    <x-hero :title="$course->name" :header="$course->subcategory->category->header" />

    <div class=" py-32">


        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="mx-auto flex max-w-2xl flex-col  justify-between gap-16 lg:mx-0 lg:max-w-none lg:flex-row">


                <div class="w-full lg:max-w-xl lg:flex-auto">
                    <div>
                        <h2 class="text-3xl font-semibold tracking-tight text-neutral-900">Kursbezeichnung</h2>
                        <p class="text-base leading-7 text-neutral-600">
                            {!! $course->description !!}
                        </p>
                    </div>

                    @if ($course->subcategory->plan->count())
                        <div class="border-b border-neutral-200 bg-white mt-12">
                            <h3 class="text-lg font-bold leading-6 py-4 px-3 bg-zinc-600 text-white rounded-t-lg">
                                Kursplan
                                {{ $course->subcategory->category->name }}
                                {{ $course->name }}</h3>

                            <ul role="list" class="divide-y divide-neutral-100 ">
                                @foreach ($course->subcategory->plan->sortBy('position') as $plan)
                                    <li
                                        class="{{ $loop->iteration % 2 === 0 ? 'row-even' : 'row-odd' }} flex gap-x-4 py-3 px-4">
                                        <p class="text-base font-semibold leading-6 text-neutral-900">
                                            {{ $plan->position }}
                                            Std.
                                        </p>
                                        <p class="mt-1 truncate text-base font-medium leading-5 text-black">
                                            {!! $plan->description !!}</p>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
                </div>

                <div class="w-full lg:max-w-lg lg:flex-auto">
                    <div class="lg:col-start-3 bg-zinc-100 py-5 shadow-sm ring-1 ring-neutral-900/5">
                        <h2 class="sr-only">Summary</h2>
                        <div class="rounded-lg ">
                            <dl class="flex flex-wrap">
                                <div class="flex-auto pl-6">
                                    <dt class="text-lg font-medium leading-6 text-neutral-900">Kurspreis</dt>
                                    <dd class="mt-1   leading-6 text-neutral-900">
                                        @if (!$totalPrice)
                                            ab
                                        @endif
                                        <span class="text-2xl font-semibold">
                                            @if (!$course->subcategory->is_club)
                                                @if (!$totalPrice)
                                                    {{ $course->subcategory->amount }}
                                                @else
                                                    {{ $totalPrice }}
                                                @endif
                                            @else
                                                {{ $minClubPrice }}
                                            @endif
                                            €
                                        </span>
                                    </dd>
                                </div>
                                <div class="mt-6 flex w-full flex-none gap-x-4 border-t border-neutral-900/5 px-6">
                                    <dt class="flex-none">
                                        <span class="sr-only">Client</span>
                                        <svg class="h-6 w-5 text-neutral-400" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </dt>
                                    <dd class="text-base font-medium leading-6 text-neutral-900">Tag:
                                        {{ $course->schedule_day }}</dd>
                                </div>
                                <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
                                    <dt class="flex-none">
                                        <span class="sr-only">Due date</span>
                                        <svg class="h-6 w-5 text-neutral-400" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path
                                                d="M5.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H6a.75.75 0 01-.75-.75V12zM6 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H6zM7.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H8a.75.75 0 01-.75-.75V12zM8 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H8zM9.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V10zM10 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H10zM9.25 14a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V14zM12 9.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V10a.75.75 0 00-.75-.75H12zM11.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V12zM12 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H12zM13.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H14a.75.75 0 01-.75-.75V10zM14 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H14z" />
                                            <path fill-rule="evenodd"
                                                d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </dt>
                                    <dd class="text-base font-medium leading-6 text-neutral-900">
                                        <time datetime="2023-01-31">Zeit: {{ $course->schedule_time_from }} bis
                                            {{ $course->schedule_time_to }} Uhr</time>
                                    </dd>
                                </div>
                                <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
                                    <dt class="flex-none">
                                        <span class="sr-only">Status</span>
                                        <svg class="h-6 w-5 text-neutral-400" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M2.5 4A1.5 1.5 0 001 5.5V6h18v-.5A1.5 1.5 0 0017.5 4h-15zM19 8.5H1v6A1.5 1.5 0 002.5 16h15a1.5 1.5 0 001.5-1.5v-6zM3 13.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zm4.75-.75a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </dt>
                                    <dd class="text-base font-medium leading-6 text-neutral-900">Veranstaltungsort: <br>
                                        {{ $course->location->address }}, {{ $course->location->zip }},
                                        {{ $course->location->city }}</dd>
                                </div>
                            </dl>
                        </div>


                        @auth('customer')
                            <div class="my-4">
                                @if (!$course->subcategory->is_club)

                                    @if ($errors->any())
                                        <div class="p-3">
                                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                                role="alert">
                                                <strong class="font-bold">Achtung!</strong>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                                    <svg class="fill-current h-6 w-6 text-red-500" role="button"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <title>Schließen</title>
                                                        <path
                                                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex flex-col justify-between px-3">
                                        <div class="flex space-x-2 mb-4">
                                            <div>
                                                <label for="quantityMen"
                                                    class="block text-sm font-medium text-neutral-700">Männer</label>
                                                <input wire:model.lazy="quantityMen" type="number" id="quantityMen"
                                                    min="0"
                                                    class="mt-1 flex-1 w-full border-neutral-300 rounded-md shadow-sm">
                                            </div>
                                            <div>
                                                <label for="quantityWomen"
                                                    class="block text-sm font-medium text-neutral-700">Frauen</label>
                                                <input wire:model.lazy="quantityWomen" type="number" id="quantityWomen"
                                                    min="0"
                                                    class="mt-1 flex-1 w-full border-neutral-300 rounded-md shadow-sm">
                                            </div>
                                        </div>

                                        <form wire:submit.prevent="createSession">
                                            <button @if (!Auth::guard('customer')->check()) disabled @endif
                                                class="disabled:bg-neutral-300 bg-red-500 w-full text-white py-2 px-4 rounded hover:bg-red-600"
                                                type="submit" id="checkout-button">Zur Kasse gehen</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="flex flex-col justify-between px-3">
                                        <livewire:BookClubAsMember />
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="p-5">
                                <h2 class="text-base mb-0 pb-0">Einloggen</h2>
                                <x-auth.login title="Melden Sie sich an, um diesen Kurs zu buchen" />
                            </div>
                        @endauth
                    </div>

                    {{-- Teachers --}}
                    <div>
                        <h2 class="text-xl font-semibold">Tanzlehrer</h2>
                        <ul role="list" class="divide-y divide-neutral-100 mt-4">
                            <li class="flex gap-x-4 ">
                                <img class="h-12 w-12 flex-none rounded-full bg-neutral-50"
                                    src="{{ $course->primaryTeacher->thumbnail }}" alt="">
                                <div class="min-w-0">
                                    <p class="text-base font-medium leading-6 text-neutral-900">
                                        {{ $course->primaryTeacher->full_name }}</p>
                                    <p class="mt-1 truncate text-sm leading-5">
                                        {{ $course->primaryTeacher->styles }}</p>
                                    <p class="mt-1 truncate text-sm leading-5">
                                        {{ $course->primaryTeacher->origin }}
                                    </p>
                                </div>
                            </li>
                            @if (isset($course->secondaryTeacher))
                                <li class="flex gap-x-4 py-5">

                                    <img class="h-12 w-12 flex-none rounded-full bg-neutral-50"
                                        src="{{ $course->secondaryTeacher->thumbnail }}" alt="">
                                    <div class="min-w-0">
                                        <p class="text-base font-medium leading-6 text-neutral-900">Michael Foster</p>
                                        <p class="mt-1 truncate text-sm leading-5">
                                            {{ $course->secondaryTeacher->styles }}
                                        </p>
                                        <p class="mt-1 truncate text-sm leading-5">
                                            {{ $course->secondaryTeacher->origin }}
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>

                    @if (isset($course->subcategory->nextSubcategory))
                        <div>
                            <h2 class="text-xl font-semibold">Anschlusskurse zu diesem Kurs</h2>
                            <ul role="list" class="divide-y divide-neutral-100">
                                <a href="{{ route('frontend.course.category', $course->subcategory->category) }}">
                                    {{ $course->subcategory->nextSubcategory->name }}
                                </a>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
