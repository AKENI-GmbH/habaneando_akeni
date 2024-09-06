<div>

    @php
        $label =
            "Mit der Anmeldung akzeptiere ich die <a target='_blank' href='" .
            route('frontend.page', 'agb') .
            "' class='text-red-600 hover:text-red-800'>Allgemeinen Geschäftsbedingungen (AGBs)</a> und die <a target='_blank' href='" .
            route('frontend.page', 'datenschutz') .
            "' class='text-red-600 hover:text-red-800'>Datenschutzbestimmungen</a>.";
    @endphp


    <!-- Hero Section -->
    <x-hero :title="$page->name" :header="$page->header" />

    <!-- Content Container -->
    <x-container>


        {{-- @auth('customer')
            @if ($this->customer->clubMember)
                <div class="text-center font-bold text-lg sm:text-xl mx-auto max-w-4xl">
                    <h2>Sie sind bereits Mitglied in unserem Tanzclub. Überprüfen Sie Ihr Profil, um Ihre
                        Mitgliedschaftsinformationen zu überprüfen</h2>
                </div>
            @else --}}
                {{-- @if ($showForm && !$showSuccess) --}}
                    <div class="mx-auto max-w-4xl text-center">
                        <p class="mt-2 text-4xl font-bold tracking-tight text-neutral-900 sm:text-4xl">Sei Teil von
                            Habaneando
                            Tanzschule</p>

                            <div class="p-4 mb-4 text-lg mt-5 text-yellow-800 rounded-lg bg-yellow-50 border-yellow-100 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                                Um der Mitgliedschaft beizutreten, ist ein Einstieg ab Mittelstufenniveau oder nach Abschluss der Stufen A1, A2 und A3 möglich.
                              </div>


                    </div>

                    <!-- Rate Categories -->
                    <di
                        class="mx-auto mt-10 text-center grid max-w-4xl grid-cols-1 gap-8 md:max-w-4xl md:grid-cols-2 lg:max-w-4xl xl:mx-auto xl:grid-cols-2">
                        @foreach ($rateCategory->take(2) as $category)
                            <div class="rounded-xl border border-neutral-200 p-4">
                                <h2 class="text-lg font-semibold leading-6 text-neutral-900">{{ $category->name }}</h2>

                                <!-- Radio Button Group -->
                                <div class="-space-y-px rounded-md bg-white mt-2">
                                    @foreach ($category->activeRates->sortBy('limit') as $rate)
                                        <labelj
                                            class="relative flex items-center cursor-pointer border-none p-4 focus:outline-none {{ $selectedRate == $rate->id ? 'bg-red-100' : '' }}">
                                            <input wire:model.lazy="selectedRate" type="radio" value="{{ $rate->id }}"
                                                class="h-4 w-4 cursor-pointer text-red-600 border-neutral-300 focus:ring-red-600">
                                            <span class="ml-3 flex flex-col">
                                                <span id="rate-{{ $loop->index }}-label"
                                                    class="block text-base font-regular text-neutral-900">{{ $rate->name }}
                                                    pro Woche, <span
                                                        class="font-bold">{{ formatPriceGerman($rate->amount) }},€</span></span>
                                            </span>
                                        </labelj>
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
                {{-- @elseif (!$showForm && $showSuccess)
                    <div class="bg-white">
                        <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
                            <div class="mx-auto max-w-2xl text-center">
                                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Vielen Dank, dass
                                    Sie Mitglied in unserem Tanzclub geworden sind!</h2>
                                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">Bitte überprüfen Sie Ihre
                                    E-Mails, um die Bestätigung zu erhalten.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mx-auto mt-10  max-w-4xl">

                        <div>

                            <div class="mb-2">
                                <h2 class="font-bold text-base sm:text-xl">Details zur Mitgliedschaft</h2>
                            </div>

                            <div class="mt-6 border-t border-neutral-100 mb-10">
                                <dl class="divide-y divide-neutral-100">
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-neutral-900">Name</dt>
                                        <dd class="mt-1 text-sm leading-6 text-neutral-700 sm:col-span-2 sm:mt-0">
                                            {{ $customer->full_name }}</dd>
                                    </div>

                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-neutral-900">E-Mail-Adresse</dt>
                                        <dd class="mt-1 text-sm leading-6 text-neutral-700 sm:col-span-2 sm:mt-0">
                                            {{ $customer->email }}</dd>
                                    </div>


                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-neutral-900">Mitgliedschaft</dt>
                                        <dd class="mt-1 text-sm leading-6 text-neutral-700 sm:col-span-2 sm:mt-0">
                                            {{ $rate->category->name }} Vertrag</dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-neutral-900">Limit pro Woche</dt>
                                        <dd class="mt-1 text-sm leading-6 text-neutral-700 sm:col-span-2 sm:mt-0">
                                            {{ $rate->name }}
                                            @if ($rate->limit > 0)
                                                pro Woche
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-neutral-900">Preis</dt>
                                        <dd class="mt-1 text-sm leading-6 text-neutral-700 sm:col-span-2 sm:mt-0">
                                            {{ $rate->amount }}, € / Monatlich</dd>
                                    </div>


                                    @if ($rate->description)
                                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-neutral-900">Beschreibung</dt>
                                            <dd class="mt-1 text-sm leading-6 text-neutral-700 sm:col-span-2 sm:mt-0">
                                                {{ $rate->description }}</dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>
                        </div>


                        <div class="mb-2">
                            <h2 class="font-bold text-base sm:text-xl">Informationen zum Lastschriftverfahren</h2>
                        </div>

                        <form wire:submit="createMembership">
                            <div class="space-y-12">
                                <div class="border-b border-neutral-900/10 pb-12">

                                    <!-- SEPA Information Section -->
                                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                        <div class="sm:col-span-3">

                                            <x-input.group for="kontoinhaber" label="kontoinhaber" :required="true"
                                                :error="$errors->first('kontoinhaber')">
                                                <x-input.text wire:model.lazy="kontoinhaber" required />
                                            </x-input.group>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <x-input.group for="iban" label="IBAN" :required="true"
                                                :error="$errors->first('iban')">
                                                <x-input.text wire:model.lazy="iban" required />
                                            </x-input.group>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <x-input.group for="bic" label="BIC" :required="true"
                                                :error="$errors->first('bic')">
                                                <x-input.text wire:model.lazy="bic" required />
                                            </x-input.group>
                                        </div>



                                        <div class="col-span-full">
                                            <x-input.group for="note" label="Kurse"
                                                helpText="Geben Sie an, welche Kurse Sie
                                              besuchen möchten."
                                                :required="true" :error="$errors->first('note')">
                                                <x-input.textarea wire:model.lazy="note" required />
                                            </x-input.group>
                                        </div>


                                    </div>

                                    <!-- Terms and Conditions Section -->
                                    <div class="col-span-full mt-4">
                                        <x-input.checkbox wire:model.change="termsAccepted" :error="$errors->first('termsAccepted')"
                                            :label="$label" />
                                    </div>
                                </div>

                                <div class="mt-6 flex items-center justify-end gap-x-6">
                                    <button type="submit"
                                        class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 disabled:bg-neutral-400"
                                        @if (!$termsAccepted) disabled @endif>
                                        Mitgliedschaft Erstellen
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            @endif
        @else
            <div class="p-5 flex items-center justify-center mx-auto w-full max-w-96 lg:w-136">
                <div>
                    <h2 class="text-base mb-0 pb-0">Einloggen</h2>
                    <x-auth.login title="Melden Sie sich an, um diesen Kurs zu buchen" />
                </div>
            </div>
        @endauth --}}
    </x-container>
</div>
