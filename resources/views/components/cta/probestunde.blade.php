@props([
    'title' => 'Neu beim Tanzen? Starte mit einer Probestunde!',
    'text' => 'Lerne unsere Tanzlehrer und die Stimmung bei Habaneando kennen – ob als Paar oder alleine, auch ganz ohne Vorkenntnisse.',
])

<div {{ $attributes->merge(['class' => 'mx-auto max-w-4xl']) }}>
    <div class="flex flex-col items-center gap-6 rounded-2xl border border-red-100 bg-red-50 px-6 py-8 text-center shadow-sm sm:flex-row sm:px-10 sm:text-left">
        <div class="flex-1">
            <h2 class="text-xl font-semibold text-neutral-900 sm:text-2xl">{{ $title }}</h2>
            <p class="mt-2 text-base leading-7 text-neutral-700">{{ $text }}</p>
        </div>
        <a href="/tanzen/probestunde"
            class="inline-block shrink-0 whitespace-nowrap rounded-md bg-red-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
            Probestunde buchen →
        </a>
    </div>
</div>
