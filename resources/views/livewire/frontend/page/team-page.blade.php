<!-- Include Alpine.js (if not already loaded) -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="teamModal()" class="relative">
    <x-hero :title="$page->name" :header="$page->header" />

    <x-container>
        <div class="mx-auto max-w-7xl px-6 text-center lg:px-8">
            <p>{!! $page->body !!}</p>
            <ul role="list"
                class="mx-auto mt-20 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($members->where('is_staff', true) as $member)
                    <li class="cursor-pointer"
                        @click="openModal({{ json_encode([
                            'id' => $member->id,
                            'full_name' => $member->full_name,
                            'thumbnail' => env('DO_CDN') . '/' . $member->thumbnail,
                            'styles' => $member->styles,
                            'bio' => $member->bio ?? 'More details about the team member...',
                            'description' => $member->description ?? 'This is a more detailed description of the team member.',
                            // Add more fields as needed (e.g., price, reviews, etc.)
                            'price' => $member->price ?? null,
                            'instagram' => $member->instagram ?? null,
                            'facebook' => $member->facebook ?? null,
                        ]) }})">
                        <img class="aspect-[3/2] w-full rounded-2xl object-cover"
                            src="{{ env('DO_CDN') . '/' . $member->thumbnail }}" alt="{{ $member->full_name }}">
                        <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-neutral-900">
                            {{ $member->full_name }}
                        </h3>
                        <p class="text-sm leading-6 text-neutral-600">{{ $member->styles }}</p>
                        <ul role="list" class="mt-6 flex justify-center gap-x-6">
                            @if ($member->instagram)
                                <li>
                                    <a href="{{ $member->instagram }}" target="_blank"
                                        class="text-neutral-400 hover:text-neutral-500">
                                        <span class="sr-only">Instagram</span>
                                        <x-icons.instagram />
                                    </a>
                                </li>
                            @endif
                            @if ($member->facebook)
                                <li>
                                    <a href="{{ $member->facebook }}" target="_blank"
                                        class="text-neutral-400 hover:text-neutral-500">
                                        <span class="sr-only">Facebook</span>
                                        <x-icons.facebook />
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-container>

    <!-- Modal -->
    <div x-show="showModal" x-cloak>
        <!-- Dark overlay (only visible on medium screens and up) -->
        <div class="fixed inset-0 hidden bg-gray-500/75 transition-opacity md:block" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">
                <!-- Modal panel with the same structure and transitions as your example -->
                <div x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 md:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 md:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                    class="flex w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl"
                    @click.outside="closeModal()">
                    <div
                        class="relative flex w-full items-center overflow-hidden bg-white px-4 pb-8 pt-14 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                        <!-- Close Button -->
                        <button type="button" @click="closeModal()"
                            class="absolute right-4 top-4 text-gray-400 hover:text-gray-500 sm:right-6 sm:top-8 md:right-6 md:top-6 lg:right-8 lg:top-8">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="grid w-full grid-cols-1 items-start gap-x-6 gap-y-8 sm:grid-cols-12 lg:gap-x-8">
                            <!-- Team member photo -->
                            <div class="sm:col-span-4 lg:col-span-5">
                                <img :src="currentMember.thumbnail" :alt="currentMember.full_name"
                                    class="aspect-square w-full rounded-lg bg-gray-100 object-cover">
                            </div>
                            <!-- Team member details -->
                            <div class="sm:col-span-8 lg:col-span-7">
                                <h2 class="text-2xl font-bold text-gray-900 sm:pr-12" x-text="currentMember.full_name">
                                </h2>

                                <section aria-labelledby="information-heading" class="mt-3">
                                    <h3 id="information-heading" class="sr-only">Information</h3>
                                    <!-- If you want to display a price or similar info -->
                                    <p class="text-2xl text-gray-900" x-text="currentMember.price"></p>

                                    <!-- Reviews section (if applicable, or remove if not needed) -->
                                    <div class="mt-3">
                                        <h4 class="sr-only">Reviews</h4>
                                        <div class="flex items-center">
                                            <!-- Here you can copy your review SVGs if needed -->
                                        </div>
                                        <p class="sr-only">Reviews details</p>
                                    </div>
                                </section>

                                <section aria-labelledby="description-heading" class="mt-6">
                                    <h4 id="description-heading" class="sr-only">Description</h4>
                                    <p class="text-sm text-gray-700" x-text="currentMember.description"></p>
                                </section>

                                <section aria-labelledby="options-heading" class="mt-6">
                                    <h3 id="options-heading" class="sr-only">Product options</h3>
                                    <form>
                                        <!-- Example form inputs/options if needed. You can remove these if not applicable. -->
                                        <div class="mt-6">
                                            <button type="submit"
                                                class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">
                                                Add to bag
                                            </button>
                                        </div>

                                        <p class="absolute left-4 top-4 text-center sm:static sm:mt-6">
                                            <a href="#"
                                                class="font-medium text-indigo-600 hover:text-indigo-500">View full
                                                details</a>
                                        </p>
                                    </form>
                                </section>

                                <!-- Additional dynamic content (e.g., bio) -->
                                <section class="mt-6">
                                    <p class="text-sm text-gray-700" x-html="currentMember.bio"></p>
                                </section>

                                <!-- Social icons -->
                                <div class="mt-4 flex space-x-4">
                                    <template x-if="currentMember.instagram">
                                        <a :href="currentMember.instagram" target="_blank"
                                            class="text-neutral-400 hover:text-neutral-500">
                                            <span class="sr-only">Instagram</span>
                                            <x-icons.instagram />
                                        </a>
                                    </template>
                                    <template x-if="currentMember.facebook">
                                        <a :href="currentMember.facebook" target="_blank"
                                            class="text-neutral-400 hover:text-neutral-500">
                                            <span class="sr-only">Facebook</span>
                                            <x-icons.facebook />
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AlpineJS component definition -->
<script>
    function teamModal() {
        return {
            showModal: false,
            currentMember: {},
            openModal(member) {
                this.currentMember = member;
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
            }
        }
    }
</script>
