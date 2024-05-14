<div>
    <x-hero :title="$page->name" :header="$page->header" />
    <x-container>
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-x-8 gap-y-20 px-6 lg:px-8 xl:grid-cols-3">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-3xl font-bold tracking-tight text-neutral-900 sm:text-4xl">Unser Team</h2>
                <p class="mt-6 text-lg leading-8 text-neutral-600">{!! $page->body !!}</p>
            </div>
            <ul role="list"
                class="mx-auto grid max-w-2xl grid-cols-1 gap-x-6 gap-y-20 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:gap-x-8 xl:col-span-2">

                @foreach ($members->where('is_staff', true) as $member)
                    <li>
                        <img class="aspect-[3/2] w-full rounded-2xl object-cover"
                            src="{{$member->thumbnail}}"
                            alt="">
                        <h3 class="mt-6 text-lg font-semibold leading-8 text-neutral-900">{{ $member->full_name }}</h3>
                        <p class="text-base leading-7 text-neutral-600">{{ $member->styles }}</p>
                        <p class="mt-4 text-base leading-7 text-neutral-600">{{ $member->description }}</p>
                        <ul role="list" class="mt-6 flex gap-x-6">

                            @if (isset($member->facebook))
                                <li>
                                    <a href="{{ $member->facebook }}" target="_blank"
                                        class="text-neutral-400 hover:text-neutral-500">
                                        <span class="sr-only">Facebook</span>
                                        <x-icons.facebook />
                                    </a>
                                </li>
                            @endif
                            @if (isset($member->instagram))
                                <li>
                                    <a href="{{ $member->instagram }}" target="_blank"
                                        class="text-neutral-400 hover:text-neutral-500">
                                        <span class="sr-only">Instagram</span>
                                        <x-icons.instagram />
                                    </a>
                                </li>
                            @endif
                            @if (isset($member->threads))
                                <li>
                                    <a href="{{ $member->threads }}" target="_blank"
                                        class="text-neutral-400 hover:text-neutral-500">
                                        <span class="sr-only">Threads</span>
                                        <x-icons.threads />
                                    </a>
                                </li>
                            @endif
                            @if (isset($member->youtube))
                                <li>
                                    <a href="{{ $member->youtube }}" target="_blank"
                                        class="text-neutral-400 hover:text-neutral-500">
                                        <span class="sr-only">Youtube</span>
                                        <x-icons.youtube />
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-container>

</div>
