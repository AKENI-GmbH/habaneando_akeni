<div>
    <x-hero :title="$page->name" :header="$page->header" />
    <x-container>
        <x-cta.probestunde class="mb-12" />

        <div>
            {!! $page->body !!}
        </div>
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <img src="{{ $cdn . $page->image }}" alt="program" />
        </div>
    </x-container>
</div>
