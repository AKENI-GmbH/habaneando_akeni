<div>
    <x-hero :title="$event->name" :header="$event->header" />

    <x-container>
        <x-grid cols="3">
            <x-grid.column class="col-span-2">

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
                                <h1 class="text-2xl mb-3 font-bold tracking-tight text-neutral-900 sm:text-3xl">AGB der
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

            </x-grid.column>

            <x-grid.column>
                <x-event.extras :extras="$event->extras" />
                @auth('customer')
                    <x-event.tickets :event="$event" />
                @else
                    <x-auth.login title="Melden Sie sich an, um diesen Event zu buchen" />
                @endauth

                <x-team :team="$event->teachers" />
            </x-grid.column>
        </x-grid>
    </x-container>

</div>
