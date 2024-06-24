<div>
    <!-- Hero Section -->
    <x-hero :title="$page->name" :header="$page->header" />

    <!-- Content Container -->
    <x-container>
        <div class="mx-auto max-w-4xl text-center">
            <p class="mt-2 text-4xl font-bold tracking-tight text-neutral-900 sm:text-5xl">Sei Teil von Habaneando
                Tanzschule</p>
        </div>

        @auth('customer')
            @if ($showForm)
                <!-- Rate Categories -->
                <di
                    class="mx-auto mt-10 text-center grid max-w-4xl grid-cols-1 gap-8 md:max-w-4xl md:grid-cols-2 lg:max-w-4xl xl:mx-auto xl:grid-cols-2">
                    @foreach ($rateCategory->take(2) as $category)
                        <div class="rounded-xl border border-neutral-200 p-4">
                            <h2 class="text-lg font-semibold leading-6 text-neutral-900">{{ $category->name }}</h2>

                            <!-- Radio Button Group -->
                            <div class="-space-y-px rounded-md bg-white mt-2">
                                @foreach ($category->activeRates->sortBy('limit') as $rate)
                                    <label
                                        class="relative flex items-center cursor-pointer border-none p-4 focus:outline-none {{ $selectedRate == $rate->id ? 'bg-red-100' : '' }}">
                                        <input wire:model.lazy="selectedRate" type="radio" value="{{ $rate->id }}"
                                            class="h-4 w-4 cursor-pointer text-red-600 border-neutral-300 focus:ring-red-600">
                                        <span class="ml-3 flex flex-col">
                                            <span id="rate-{{ $loop->index }}-label"
                                                class="block text-base font-regular text-neutral-900">{{ $rate->name }}
                                                pro Woche, <span
                                                    class="font-bold">{{ formatPriceGerman($rate->amount) }},€</span></span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Buy Plan Button -->
                            <a href="#" wire:click.prevent="purchasePlan({{ $selectedRate }})"
                                class="block mt-4 rounded-md py-2 px-3 text-sm font-semibold leading-6 text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-500 focus:ring-opacity-50">
                                Anmelden
                            </a>

                        </div>
                    @endforeach


                </di>
            @else
                <div class="mx-auto mt-10 text-center max-w-4xl">
                    <p class="text-xl font-bold text-green-600">Plan purchased successfully!</p>
                    <p>Selectable courses: {{ $selectableCourses }}</p>
                    <a href="#" wire:click.prevent="createMembership"
                        class="block mt-4 rounded-md py-2 px-3 text-sm font-semibold leading-6 text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-500 focus:ring-opacity-50">
                        Mitgliedschaft erstellen
                    </a>
                </div>
            @endif
        @else
            <div class="p-5 flex items-center justify-center mx-auto w-full max-w-96 lg:w-136">
                <div>
                    <h2 class="text-base mb-0 pb-0">Einloggen</h2>
                    <x-auth.login title="Melden Sie sich an, um diesen Kurs zu buchen" />
                </div>
            </div>
        @endauth
    </x-container>
</div>
