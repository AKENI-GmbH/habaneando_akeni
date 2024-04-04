<header class="h-24 absolute inset-x-0 top-0 z-50">
    <div class="flex items-center w-full h-full max-w-screen-xl px-5 mx-auto sm:px-6 lg:px-8">
        <nav class="relative z-50 flex items-center justify-between w-full">
            <div class="flex items-center shrink-0">
                <a href="{{ route('frontend.home') }}" aria-label="Home" class="flex items-center flex-shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt=""
                        class="w-auto h-16 sm:h-16 md:hidden lg:block lg:h-24" />
                    <img src="{{ asset('images/logo.png') }}" alt=""
                        class="hidden w-auto h-20 md:block lg:hidden" />
                </a>
            </div>

            <div class="items-center hidden md:flex md:space-x-6 lg:space-x-8">
                @foreach ($navigation as $item)
                    @if (isset($item['link']) && $item['link'])
                        <a href="{{ $item['link'] }}" class="relative text-xs uppercase text-white font-semibold">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <div class="relative" x-data="{ open: false }">
                            <!-- Pages dropdown button -->
                            <button type="button"
                                class="flex items-center relative text-xs uppercase text-white font-semibold duration-200 ease-in-out group"
                                :class="open ? 'text-white' : 'text-white  hover:text-gray-200'" @click="open = true">
                                <span>{{ $item['label'] }}</span>

                                <!-- Heroicon name: solid/chevron-down -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 duration-300"
                                    :class="open ? 'rotate-180 text-white' : 'text-white group-hover:text-gray-300'">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Pages dropdown -->
                            <div style="display: none"
                                class="absolute right-0 z-20 mt-3 w-52  bg-gray-100 rounded-md drop-shadow filter focus:outline-none outline-none"
                                x-show.transition="open" @click.away="open = false">
                                @foreach ($item['submenu'] as $category)
                                    @if (isset($category['link']))
                                        <a href="{{ $category['link'] }}"
                                            class="block px-4 py-2.5 font-base border-none hover:bg-neutral-800 text-neutral-300 bg-neutral-700  transition duration-300 ease-in-out  hover:text-white">
                                            {{ $category['name'] ?? $category['label'] }}
                                        </a>
                                    @elseif(isset($category['form']) && $category['form'])
                                        <form action="{{ $category['action'] }}" method="POST" class="inline">
                                            @csrf
                                            <button
                                                class="block py-3.5 px-5 font-medium w-full text-left  hover:bg-red-700 text-black  transition duration-300 ease-in-out  hover:text-white">
                                                {{ $category['label'] }}
                                            </button>
                                        </form>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="sm:hidden items-center flex">
                <div class="ml-4 md:hidden" x-data="{ mobileMenuOpen: false }">
                    <button
                        class="relative z-50 flex items-center justify-center p-3 transition duration-300 ease-in-out rounded-full shadow-sm cursor-pointer group bg-slate-100/80 shadow-sky-100/50 ring-1 ring-slate-900/5 hover:bg-slate-200/60 focus:outline-none md:hidden"
                        aria-label="Toggle Navigation" @click="mobileMenuOpen=!mobileMenuOpen">
                        <span class="relative h-3.5 w-4 transform transition duration-500 ease-in-out">
                            <span
                                class="absolute block h-0.5 rotate-0 transform rounded-full bg-slate-700 opacity-100 transition-all duration-300 ease-in-out group-hover:bg-slate-900"
                                :class="mobileMenuOpen ? 'top-1.5 left-1/2 w-0' : 'top-0 left-0 w-full'"></span>
                            <span
                                class="absolute left-0 top-1.5 block h-0.5 w-full transform rounded-full bg-slate-700 opacity-100 transition-all duration-300 ease-in-out group-hover:bg-slate-900"
                                :class="mobileMenuOpen ? 'rotate-45' : 'rotate-0'"></span>
                            <span
                                class="absolute left-0 top-1.5 block h-0.5 w-full transform rounded-full bg-slate-700 opacity-100 transition-all duration-300 ease-in-out group-hover:bg-slate-900"
                                :class="mobileMenuOpen ? '-rotate-45' : 'rotate-0'"></span>
                            <span
                                class="absolute block h-0.5 rotate-0 transform rounded-full bg-slate-700 opacity-100 transition-all duration-300 ease-in-out group-hover:bg-slate-900"
                                :class="mobileMenuOpen ? 'top-1.5 left-1/2 w-0' : 'left-0 top-3 w-full'"></span>
                        </span>
                    </button>


                    <div class="md:hidden">
                        <!-- Background dark overlay when mobile menu is open -->
                        <div x-show="mobileMenuOpen" x-transition:enter="duration-200 ease-out"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="duration-150 ease-in" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-opacity-80 bg-red-900"
                            style="display: none"></div>

                        <!-- Mobile menu popover -->
                        <div x-show="mobileMenuOpen" x-transition:enter="duration-300 ease-out"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="duration-200 ease-in" x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90"
                            class="absolute inset-x-0 z-30 px-6 mt-4 overflow-hidden origin-top shadow-xl top-full rounded-2xl bg-slate-50 py-7 shadow-sky-100/40 ring-1 ring-slate-900/5"
                            style="display: none" @click.away="mobileMenuOpen = false">
                            <div>
                                <!-- Mobile menu links -->
                                <div class="flex flex-col space-y-4">
                                    @foreach ($navigation as $item)
                                        @if (isset($item['link']) && $item['link'])
                                            <a href="{{ $item['link'] }}"
                                                class="block text-base font-semibold duration-200 text-slate-700 hover:bg-red-700 hover:text-white p-2.5">
                                                {{ $item['label'] }}
                                            </a>
                                        @else
                                            <div class="relative" x-data="{ open: false }">
                                                <button
                                                    class="flex items-center w-full gap-2 text-base font-semibold duration-200 p-2.5 text-slate-700 hover:bg-red-700 hover:text-white p-2.5ease-in-out group"
                                                    :class="open ? 'text-slate-900' : 'text-slate-700 hover:text-slate-900'"
                                                    @click="open = !open">
                                                    <span>{{ $item['label'] }}</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-5 h-5 duration-300"
                                                        :class="open ? 'rotate-90 text-slate-900' :
                                                            'text-slate-700  group-hover:text-slate-900'">
                                                        <path fill-rule="evenodd"
                                                            d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>

                                                <!-- Dropdown links list -->
                                                <ul style="display: none" class="z-20 px-3 space-y-4"
                                                    x-show.transition="open">
                                                    @foreach ($item['submenu'] as $dropdownItem)
                                                        @if (isset($dropdownItem['link']))
                                                            <li class="mt-4">
                                                                <a href="{{ $dropdownItem['link'] }}"
                                                                    class="block font-medium transition duration-200 hover:bg-red-700 hover:text-white  ease-in-out text-md text-slate-700 py-2.5 px-3">
                                                                    {{ $dropdownItem['name'] ?? $dropdownItem['label'] }}
                                                                </a>
                                                            </li>
                                                        @elseif(isset($dropdownItem['form']) && $dropdownItem['form'])
                                                            <form action="{{ $dropdownItem['action'] }}" method="POST"
                                                                class="inline">
                                                                @csrf
                                                                <button
                                                                    class="block font-medium transition duration-200 hover:bg-red-700 hover:text-white  ease-in-out text-md text-slate-700 py-2.5 px-3 w-full text-left">
                                                                    {{ $dropdownItem['label'] }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
