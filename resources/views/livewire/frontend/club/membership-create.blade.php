<div>
    <!-- Hero Section -->
    <x-hero :title="$page->name" :header="$page->header" />

    <!-- Content Container -->
    <x-container>
        <div class="mx-auto max-w-4xl text-center">
            <p class="mt-2 text-4xl font-bold tracking-tight text-neutral-900 sm:text-5xl">Sei Teil von Habaneando
                Tanzschule</p>
        </div>
        {{-- <p class="mx-auto mt-6 max-w-2xl text-center text-lg leading-8 text-neutral-600">Lorem ipsum dolor sit amet,
            consectetur adipisicing elit. Dicta, corporis reiciendis laudantium magnam tenetur iure natus eius minus?
            Nemo similique, odio reprehenderit vitae maiores facilis. Iure aut perferendis odit voluptatum.</p> --}}

        <!-- Rate Categories -->
        <div
            class="mx-auto mt-10 text-center grid max-w-4xl grid-cols-1 gap-8 md:max-w-4xl md:grid-cols-2 lg:max-w-4xl xl:mx-auto xl:grid-cols-2">
            @foreach ($rateCategory as $category)
                <div class="rounded-xl border border-neutral-200 p-4">
                    <h2 class="text-lg font-semibold leading-6 text-neutral-900">{{ $category->name }}</h2>
                    <p class="mt-2 text-sm text-neutral-600 font-semibold">Ab
                        <span
                            class="text-lg font-bold text-neutral-900">{{ formatPriceGerman($category->rates->min('amount')) }}€</span>
                        / Monat
                    </p>

                    <!-- Radio Button Group -->
                    <div class="-space-y-px rounded-md bg-white mt-2">
                        @foreach ($category->activeRates->sortBy('limit') as $rate)
                            <label
                                class="relative flex items-center cursor-pointer border-none p-4 focus:outline-none {{ $selectedRate == $rate->id ? 'bg-red-100' : '' }}">
                                <input wire:model="selectedRate" type="radio" value="{{ $rate->id }}"
                                    class="h-4 w-4 cursor-pointer text-red-600 border-neutral-300 focus:ring-red-600">
                                <span class="ml-3 flex flex-col">
                                    <span id="rate-{{ $loop->index }}-label"
                                        class="block text-base font-regular text-neutral-900">{{ $rate->name }}, <span
                                            class="font-bold">{{ formatPriceGerman($rate->amount) }},€</span></span>
                                    {{-- <span class="block text-sm text-neutral-500">{{ $rate->description }}</span> --}}
                                </span>
                            </label>
                        @endforeach
                    </div>



                    <!-- Buy Plan Button -->
                    <a href="#" wire:click.prevent="purchasePlan({{ $selectedRate }})"
                        class="block mt-4 rounded-md py-2 px-3 text-sm font-semibold leading-6 text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-500 focus:ring-opacity-50">
                        Plan kaufen
                    </a>
                </div>
            @endforeach
        </div>
    </x-container>
</div>
