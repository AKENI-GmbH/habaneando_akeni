<div>
    <x-hero :title="$event->name" :header="$event->header" />

    <div class=" py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto flex max-w-2xl flex-col  justify-between gap-16 lg:mx-0 lg:max-w-none lg:flex-row">

                <div class="w-full lg:max-w-3xl lg:flex-auto">
                    <h1 class="mt-0 text-2xl font-bold tracking-tight text-neutral-900 sm:text-3xl">{{ $event->name }}
                    </h1>
                    <p class="mt-2 text-base mb-5">
                        <time datetime="{{ $event->date_from }}"
                            class="text-neutral-500">{{ Carbon\Carbon::parse($event->date_from)->format('D, d.M ') }}
                            -{{ Carbon\Carbon::parse($event->time_from)->format('H:i') }}-{{ Carbon\Carbon::parse($event->time_to)->format('H:i') }}
                            Uhr</time>
                    </p>

                    <x-tabs default="tab-general">
                        <x-slot name="buttons">
                            <x-tabs.button Identifier="tab-general" label="infos" />
                            @if ($event->program)
                                <x-tabs.button Identifier="tab-program" label="Programm" />
                            @endif

                            @if ($event->conditions)
                                <x-tabs.button Identifier="tab-agb" label="AGB" />
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <x-tabs.panel identifier="tab-general">
                                {!! $event->description !!}
                            </x-tabs.panel>

                            @if ($event->conditions)
                                <x-tabs.panel identifier="tab-agb">
                                    <h1 class="text-2xl mb-3 font-bold tracking-tight text-neutral-900 sm:text-3xl">AGB
                                        der
                                        Veranstaltung</h1>

                                    <div>
                                        {!! $event->conditions !!}
                                    </div>
                                </x-tabs.panel>
                            @endif

                            @if ($event->program)
                                <x-tabs.panel identifier="tab-program">
                                    <div>
                                        {!! $event->program !!}
                                    </div>
                                </x-tabs.panel>
                            @endif

                        </x-slot>
                    </x-tabs>


                </div>

                <div class="w-full lg:max-w-sm lg:flex-auto">
                    <img src="{{ $event->thumbnail }}" alt=""
                        class="mb-5 aspect-[16/9] w-full  bg-neutral-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">

                    <x-event.extras :extras="$event->extras" />

                    @if ($event->onlyDoor)
                        <div>
                            <h3 class="font-bold text-md">Eintritt nur an der Abendkasse</h3>
                            <p class="mt-10">Der Eintritt zu dieser Veranstaltung ist ausschließlich an der Abendkasse
                                möglich. Wir
                                freuen
                                uns auf Ihren Besuch!</p>
                        </div>
                    @else
                        @auth('customer')
                            <div class="lg:col-start-3 bg-zinc-100 py-5 shadow-sm ring-1 ring-neutral-900/5">
                                <div class="px-4">
                                    <h3 class="font-bold text-lg">Tickets kaufen</h3>

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


                                    @if ($event->ticketType)
                                        <x-input.group for="ticket" label="Ticket wählen">
                                            <x-input.select wire:model="ticket">
                                                <option value="">Ticket auswählen</option>
                                                @foreach ($event->ticketType->tickets->where('valid_date_from' >= Date::now())->where('valid_date_until' <= Date::now()) as $ticket)
                                                    <option value="{{ $ticket->id }}">{{ $ticket->name }}
                                                        {{ formatPriceGerman($ticket->amount) }}€</option>
                                                @endforeach
                                            </x-input.select>
                                        </x-input.group>
                                        <x-input.group for="quantity" label="Menge" class="mt-4">
                                            <x-input.text wire:model.lazy="quantity" min="1" value="1" type="number" />
                                        </x-input.group>
                                    @endif

                                    <form wire:submit.prevent="createSession" class="mt-4">
                                        <button @if (!Auth::guard('customer')->check()) disabled @endif
                                            class="disabled:bg-neutral-300 bg-red-500 w-full text-white py-2 px-4 rounded hover:bg-red-600"
                                            type="submit" id="checkout-button">Zur Kasse gehen</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <x-auth.login title="Melden Sie sich an, um diesen Event zu buchen" />
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>


</div>
