<div>
    <x-hero :title="$category->name" :description="$category->description" :header="$category->header" />

    <x-container>
        @foreach ($category->subcategories as $subcategory)
            @if ($subcategory->courses->isNotEmpty())
                <div class="my-10 border-b-1 border-b-gray-300 pb-10">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-600">{{ $subcategory->level }}</h1>
                            @if ($subcategory->description)
                                <p class="mt-2 text-base text-gray-700">{!! $subcategory->description !!}</p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 flow-root">
                        <div class=" overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <table class="min-w-full divide-y divide-gray-300 table-alternate">
                                    <thead>
                                        <tr class=" ">
                                            <th scope="col"
                                                class="bg-red-600 py-3.5 pl-4 pr-3 text-left text-base font-bold text-white sm:pl-6 lg:pl-8">
                                                Kursbezeichnung </th>
                                            <th scope="col"
                                                class="bg-red-600 px-3 py-3.5 text-left text-base font-bold text-white">
                                                Ort</th>
                                            <th scope="col"
                                                class="bg-red-600 px-3 py-3.5 text-left text-base font-bold text-white">
                                                Kursbeginn</th>
                                            <th scope="col"
                                                class="bg-red-600 px-3 py-3.5 text-left text-base font-bold text-white">
                                                Uhrzeit
                                            </th>
                                            <th scope="col"
                                                class="bg-red-600 relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach ($subcategory->courses->where('start_date', '>', now())->sortBy('start_date') as $course)
                                            <tr>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-base font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                                    <a class="text-black hover:text-red-600 hover:decoration-transparent"
                                                        href="{{ route('frontend.course.show', $course) }}">{{ $course->name }}</a>
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-base text-gray-500">
                                                    {{ $course->location->city }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-base text-gray-500">
                                                    {{ $course->dayAbbreviation }}
                                                    @if ($course->endless)
                                                        Fortlaufender
                                                    @else
                                                        {{ Date::parse($course->start_date)->format('j. M Y') }}
                                                    @endif
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-base text-gray-500">
                                                    {{ $course->schedule_time_from }} bis
                                                    {{ $course->schedule_time_to }} Uhr</td>
                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-base font-medium sm:pr-6 lg:pr-8">
                                                    <a href="{{ route('frontend.course.show', $course) }}"
                                                        class="text-black hover:text-red-600">Anmelden</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </x-container>
</div>
