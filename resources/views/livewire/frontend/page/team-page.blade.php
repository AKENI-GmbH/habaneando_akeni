<!-- Include Alpine.js if not already loaded -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="teamModal()" class="relative">
    <x-hero title="Our Team" header="Meet the Team" />

    <x-container>
        <div class="mx-auto max-w-7xl px-6 text-center">
            <ul role="list"
                class="mx-auto mt-20 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($members->where('is_staff', true) as $member)
                    <li class="cursor-pointer"
                        @click="openModal({
                first_name: '{{ $member->first_name }}',
                last_name: '{{ $member->last_name }}',
                show_name: '{{ $member->show_name }}',
                origin: '{{ $member->origin }}',
                description: '{{ $member->description }}',
                thumbnail: '{{ env('DO_CDN') . '/' . $member->thumbnail }}',
                facebook: '{{ $member->facebook }}',
                instagram: '{{ $member->instagram }}',
                youtube: '{{ $member->youtube }}',
                threads: '{{ $member->threads }}',
                styles: '{{ $member->styles }}'
              })">
                        <img src="{{ env('DO_CDN') . '/' . $member->thumbnail }}"
                            alt="{{ $member->first_name }} {{ $member->last_name }}"
                            class="aspect-[3/2] w-full rounded-2xl object-cover">
                        <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-neutral-900">
                            @if ($member->show_name)
                                {{ $member->first_name }} {{ $member->last_name }}
                            @endif
                        </h3>
                        <p class="text-sm leading-6 text-neutral-600">{{ $member->styles }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-container>

    <!-- Modal -->
    <div x-show="showModal" x-cloak>
        <!-- Dark overlay -->
        <div class="fixed inset-0 hidden bg-gray-500/75 transition-opacity md:block" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">
                <!-- Modal panel -->
                <div class="flex w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 md:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 md:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                    @click.outside="closeModal()">
                    <div
                        class="relative flex w-full items-center overflow-hidden bg-white px-4 pb-8 pt-14 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                        <!-- Close Button -->
                        <button type="button" @click="closeModal()"
                            class="absolute right-4 top-4 text-gray-400 hover:text-gray-500 sm:right-6 sm:top-8 md:right-6 md:top-6 lg:right-8 lg:top-8">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="grid w-full grid-cols-1 items-start gap-x-6 gap-y-8 sm:grid-cols-12 lg:gap-x-8">
                            <!-- Member Photo -->
                            <div class="sm:col-span-4 lg:col-span-5">
                                <img :src="currentMember.thumbnail"
                                    :alt="currentMember.first_name + ' ' + currentMember.last_name"
                                    class="aspect-square w-full rounded-lg bg-gray-100 object-cover">
                            </div>
                            <!-- Member Details -->
                            <div class="sm:col-span-8 lg:col-span-7">
                                <h2 class="text-2xl font-bold text-gray-900 sm:pr-12">
                                    <span x-text="currentMember.first_name"></span>
                                    <span x-text="currentMember.last_name"></span>
                                </h2>
                                <p class="mt-1 text-sm text-gray-500" x-text="currentMember.origin"></p>
                                <p class="mt-4 text-sm text-gray-700" x-text="currentMember.description"></p>
                                <p class="mt-4 text-sm text-gray-700" x-text="currentMember.styles"></p>

                                <!-- Social Icons -->
                                <div class="mt-6 flex space-x-4">
                                    <template x-if="currentMember.instagram">
                                        <a :href="currentMember.instagram" target="_blank"
                                            class="text-blue-500 hover:text-blue-700">
                                            <span class="sr-only">Instagram</span>
                                            <x-icons.instagram />
                                        </a>
                                    </template>
                                    <template x-if="currentMember.facebook">
                                        <a :href="currentMember.facebook" target="_blank"
                                            class="text-blue-500 hover:text-blue-700">
                                            <span class="sr-only">Facebook</span>
                                            <x-icons.facebook />
                                        </a>
                                    </template>
                                    <template x-if="currentMember.youtube">
                                        <a :href="currentMember.youtube" target="_blank"
                                            class="text-red-500 hover:text-red-700">
                                            <span class="sr-only">YouTube</span>
                                            <x-icons.youtube />
                                        </a>
                                    </template>
                                    <template x-if="currentMember.threads">
                                        <a :href="currentMember.threads" target="_blank"
                                            class="text-gray-500 hover:text-gray-700">
                                            <span class="sr-only">Threads</span>
                                            <!-- Replace with your custom Threads icon -->
                                            <svg class="h-6 w-6" fill="currentColor"
                                                viewBox="0 0 24 24"><!-- Your Threads SVG here --></svg>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Modal Panel -->
            </div>
        </div>
    </div>
</div>

<!-- AlpineJS Component -->
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
