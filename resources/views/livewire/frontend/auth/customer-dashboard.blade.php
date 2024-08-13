<div>
    <x-hero :title="$page->name" :header="$page->header" />

    <x-container>
        <div>
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                <select id="tabs" name="tabs"
                    class="block w-full rounded-md border-neutral-300 focus:border-indigo-500 focus:ring-indigo-500"
                    wire:model="activeTab">
                    <option value="my-account">My Account</option>
                    <option value="company">Company</option>
                    <option value="team-members">Team Members</option>
                    <option value="billing">Billing</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <nav class="flex space-x-4" aria-label="Tabs">
                    <!-- Current: "bg-red-500 text-neutral-100", Default: "text-neutral-500 hover:text-neutral-700" -->
                    <a href="#"
                        class="rounded-md px-3 py-2 text-sm font-medium {{ $activeTab === 'my-account' ? 'bg-red-500 text-neutral-100' : 'text-neutral-500 hover:text-neutral-700' }}"
                        wire:click.prevent="setActiveTab('my-account')">Mein Konto</a>
                    <a href="#"
                        class="rounded-md px-3 py-2 text-sm font-medium {{ $activeTab === 'membership' ? 'bg-red-500 text-neutral-100' : 'text-neutral-500 hover:text-neutral-700' }}"
                        wire:click.prevent="setActiveTab('membership')">Meine Clubmitgliedschaft</a>
                </nav>
            </div>
        </div>

        <div class="mt-6">
            @if ($activeTab === 'my-account')
                <div>Willkommen in Ihrem Habaneando-Konto</div>
            @elseif ($activeTab === 'membership')
                @if ($membership)
                    <div>

                        <div class="mb-2">
                            <h2 class="font-bold text-base sm:text-xl">Details zur Mitgliedschaft</h2>
                        </div>

                        <div class="mt-6 border-t border-neutral-100 mb-10">
                            <dl class="divide-y divide-neutral-100">
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-neutral-900">Mitgliedschaft</dt>
                                    <dd class="mt-1 text-sm leading-6 text-neutral-700 sm:col-span-2 sm:mt-0">
                                        {{ $membership->clubRate->name }}, {{ $membership->clubRate->category->name }}
                                        Vertrag</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm font-medium leading-6 text-neutral-900">Preis</dt>
                                    <dd class="mt-1 text-sm leading-6 text-neutral-700 sm:col-span-2 sm:mt-0">
                                        {{ $membership->amount }}, € / Monatlich</dd>
                                </div>


                                {{-- @if ($rate->description)
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-neutral-900">Beschreibung</dt>
                                <dd class="mt-1 text-sm leading-6 text-neutral-700 sm:col-span-2 sm:mt-0">
                                    {{ $rate->description }}</dd>
                            </div>
                        @endif --}}
                            </dl>
                        </div>
                    </div>
                @else
                    <div>Sie haben noch keine aktive Mitgliedschaft</div>
                @endif
                {{-- @elseif ($activeTab === 'team-members')
                <div>Team Members Content</div>
            @elseif ($activeTab === 'billing')
                <div>Billing Content</div> --}}
            @endif
        </div>
    </x-container>
</div>
