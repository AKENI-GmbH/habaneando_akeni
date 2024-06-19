<div>
    <x-hero :title="$page->name" :header="$page->header" />

    <x-container>
        <div class="mx-auto max-w-7xl px-6 text-center lg:px-8">

            <p>{!! $page->body !!}</p>
            <ul role="list"
                class="mx-auto mt-20 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($members->where('is_staff', true) as $member)
                    <li>
                        <img class="aspect-[3/2] w-full rounded-2xl object-cover" src="{{ $member->thumbnail }}"
                            alt="">
                        <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-neutral-900">
                            {{ $member->full_name }}</h3>
                        <p class="text-sm leading-6 text-neutral-600">{{ $member->styles }}</p>
                        <ul role="list" class="mt-6 flex justify-center gap-x-6">
                            @if (isset($member->instagram))
                                <li>
                                    <a href="{{ $member->instagram }}" target="_blank"
                                        class="text-neutral-400 hover:text-neutral-500">
                                        <span class="sr-only">Instagram</span>
                                        <x-icons.instagram />
                                    </a>
                                </li>
                            @endif
                            @if (isset($member->facebook))
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
                <!-- More people... -->
            </ul>
        </div>
    </x-container>
</div>
