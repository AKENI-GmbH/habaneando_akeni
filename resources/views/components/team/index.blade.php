@props(['team' => []])

<div>
    <h2 class="text-xl font-semibold">Tanzlehrer</h2>

    <ul role="list" class="divide-y divide-gray-100">
        @foreach ($team as $member)
            <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="{{ $member->thumbnail }}" alt="">
                    <div class="min-w-0 flex-auto">
                        <p class="text-base font-semibold leading-6 text-gray-900">{{ $member->full_name }}</p>
                        <p class="mt-1 truncate text-sm leading-5 text-black">{{ $member->origin }}</p>
                    </div>
                </div>
                {{-- <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
      <p class="text-sm leading-6 text-gray-900">Co-Founder / CEO</p>
      <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time datetime="2023-01-23T13:23Z">3h ago</time></p>
    </div> --}}
            </li>
        @endforeach


    </ul>
</div>
