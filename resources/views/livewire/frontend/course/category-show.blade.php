<div>
    <x-hero :title="$category->name" :description="$category->description" :header="$category->header" />

    <x-container>
        @foreach ($category->subcategories as $subcategory)
            @if ($subcategory->courses->isNotEmpty())
                <div class="my-10 border-b-1 border-b-neutral-300 pb-10">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-neutral-600">{{ $subcategory->level }}</h1>
                            @if ($subcategory->description)
                                <p class="mt-2 text-base text-neutral-700">{!! $subcategory->description !!}</p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 flow-root">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-neutral-300 table-alternate">
                                <thead>
                                    <tr class="bg-red-600 text-white">
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left font-bold">Kursbezeichnung
                                        </th>
                                        {{-- <th scope="col" class="px-3 py-3.5 text-left font-bold">Ort</th> --}}
                                        <th scope="col" class="px-3 py-3.5 text-left font-bold">Kursbeginn</th>
                                        <th scope="col" class="px-3 py-3.5 text-left font-bold">Uhrzeit</th>
                                        <th scope="col" class="py-3.5 pl-3 pr-4"> </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-200 bg-white">
                                    @foreach ($subcategory->courses as $course)
                                        @if ($course->subcategory->is_club || $course->start_date >= now())
                                            <tr>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-base font-medium text-neutral-900">
                                                    <a href="{{ route('frontend.course.show', $course) }}"
                                                        class="text-black hover:text-red-600 hover:decoration-transparent">{{ $course->name }}</a>
                                                </td>
                                                {{-- <td class="whitespace-nowrap px-3 py-4 text-base text-neutral-500">
                                                    {{ $course->location->city }}</td> --}}
                                                <td class="whitespace-nowrap px-3 py-4 text-base text-neutral-500">
                                                    @if ($course->endless)
                                                    {{ \Carbon\Carbon::parse($course->start_date)->isoFormat('dd') }}. Fortlaufender 
                                                    @else
                                                        {{ \Carbon\Carbon::parse($course->start_date)->isoFormat('dd D. MMM YYYY') }}
                                                    @endif
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-base text-neutral-500">
                                                    {{ $course->schedule_time_from }} bis
                                                    {{ $course->schedule_time_to }} Uhr</td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-base font-medium">
                                                    <a href="{{ route('frontend.course.show', $course) }}"
                                                        class="text-black hover:text-red-600">Anmelden</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </x-container>
</div>
