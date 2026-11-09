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


        <div class="mx-auto max-w-4xl text-center">
            <p class="mt-2 text-4xl font-bold tracking-tight text-neutral-900 sm:text-4xl">Sei Teil von
                Habaneando
                Tanzschule</p>

            <div class="p-4 mb-4 text-lg mt-5 text-yellow-800 rounded-lg bg-yellow-50 border-yellow-100 dark:bg-gray-800 dark:text-yellow-300"
                role="alert">
                Um der Mitgliedschaft beizutreten, ist ein Einstieg ab Mittelstufenniveau oder nach Abschluss
                der Stufen A1, A2 und A3 möglich.
            </div>


            <div>

                Vorteile und Ermäßigungen für Clubmitglieder:
                ★ 10 € Rabatt auf Intensiv-Workshops
                ★ 6-Wochen-Kurs: 15 € Rabatt
                ★ 10 € Rabatt auf Privatunterricht
                ★ 10 € Rabatt auf Tanzschuhe
                ★ 50 € Rabatt auf Tanzreisen
                ★ Rabatt auf Events & Workshops vor den Parties (Details vor Ort)
                ★ Übungsabend inbegriffen
            </div>

        </div>

        @auth('customer')
            @if ($this->customer->clubMember)
                <div class="text-center font-bold text-lg sm:text-xl mx-auto max-w-4xl">
                    <h2>Sie sind bereits Mitglied in unserem Tanzclub. Überprüfen Sie Ihr Profil, um Ihre
                        Mitgliedschaftsinformationen zu überprüfen</h2>
                </div>
            @else
                @if ($showForm && !$showSuccess)
                    <!-- Rate Categories -->
                    @php
                        $subtitles = [
                            6 => 'Beliebt und günstig',
                            12 => 'Dein bester Preis',
                            1 => 'Flexibel starten',
                        ];
                    @endphp

                    <div class="mx-auto mt-10 max-w-5xl">
                        <p class="mb-6 text-center text-sm text-neutral-600 md:text-right">Alle Preise pro Monat</p>

                        <div class="grid grid-cols-1 gap-8 text-center md:grid-cols-3 md:gap-4">
                            @foreach ($rateCategory->sortBy('position') as $category)
                                @php $isBestOffer = (int) $category->duration === 12; @endphp

                                <div
                                    class="relative rounded-xl border p-4 {{ $isBestOffer ? 'border-yellow-300 bg-yellow-50' : 'border-neutral-200' }}">
                                    @if ($isBestOffer)
                                        <span
                                            class="absolute -top-3 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-red-600 px-3 py-1 text-xs font-semibold uppercase text-white">
                                            ★ Unser bestes Angebot
                                        </span>
                                    @endif

                                    <h2 class="mt-2 text-lg font-semibold uppercase leading-6 text-neutral-900">
                                        {{ $category->name }}</h2>
                                    <p class="mt-1 text-sm text-neutral-600">{{ $subtitles[$category->duration] ?? '' }}
                                    </p>

                                    <!-- Radio Button Group -->
                                    <div class="mt-3 space-y-1">
                                        @foreach ($category->activeRates->sortBy('amount') as $rate)
                                            <label wire:key="rate-{{ $rate->id }}"
                                                class="flex cursor-pointer items-center rounded-md p-3 text-left {{ $selectedRate == $rate->id ? 'bg-red-100' : '' }}">
                                                <input wire:model.live="selectedRate" type="radio" name="selectedRate"
                                                    value="{{ $rate->id }}"
                                                    class="h-4 w-4 cursor-pointer border-neutral-300 text-red-600 focus:ring-red-600">
                                                <span class="ml-3 text-base text-neutral-900">{{ $rate->name }}{{ $rate->limit > 0 ? '/Woche' : '' }}</span>
                                                <span
                                                    class="ml-auto whitespace-nowrap pl-2 font-bold text-neutral-900">{{ formatPriceGerman($rate->amount) }}
                                                    €</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Buy Plan Button -->
                        <div class="mt-8 text-center">
                            <button type="button" wire:click="purchasePlan({{ $selectedRate ?? 'null' }})"
                                @disabled(!$selectedRate)
                                class="w-full rounded-md bg-red-600 px-6 py-2 text-sm font-semibold leading-6 text-white hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-500 focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-neutral-400 sm:w-auto">
                                Anmelden
                            </button>
                        </div>
                    </div>
                @elseif (!$showForm && $showSuccess)
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
                                            {{ $rate->category->name }} Laufzeit</dd>
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
                                            {{ formatPriceGerman($rate->amount) }} € / Monatlich</dd>
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
            {{-- <div class="text-center  mx-auto max-w-4xl">
                <h2 class="font-bold text-lg sm:text-xl">Sie sind bereits Mitglied in unserem Tanzclub. Überprüfen Sie Ihr Profil, um Ihre
                    Mitgliedschaftsinformationen zu überprüfen</h2>
            </div> --}}

            <div class="mt-10 p-5 flex items-center justify-center mx-auto w-full max-w-96 lg:w-136">
                <div>
                    <h2 class="text-base mb-0 pb-0">Einloggen</h2>
                    <x-auth.login title="Melden Sie sich an, um diesen Kurs zu buchen" />
                </div>
            </div>
        @endauth
    </x-container>
</div>
