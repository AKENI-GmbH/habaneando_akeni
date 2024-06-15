<div>
    <x-hero :title="$event->name" :header="$event->header" />

    <div class="bg-white py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div
                class="mx-auto flex max-w-2xl flex-col  justify-between gap-16 lg:mx-0 lg:max-w-none lg:flex-row">

                <div class="w-full lg:max-w-xl lg:flex-auto">
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

                <div class="w-full lg:max-w-lg lg:flex-auto">
                    <x-event.extras :extras="$event->extras" />

                    @if ($event->onlyDoor)
                        <div>
                            <h3 class="font-bold text-md">Eintritt nur an der Abendkasse</h3>
                            <p>Der Eintritt zu dieser Veranstaltung ist ausschließlich an der Abendkasse möglich. Wir
                                freuen
                                uns auf Ihren Besuch!</p>
                        </div>
                    @else
                        @auth('customer')
                            <x-event.tickets :event="$event" />
                        @else
                            <x-auth.login title="Melden Sie sich an, um diesen Event zu buchen" />
                        @endauth

                    @endif
                </div>
            </div>
        </div>
    </div>


</div>
