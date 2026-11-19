<div>
    <x-hero :title="$page->name" :header="$page->header" />
    <x-container>
        <div>
            {!! $page->body !!}
        </div>
        <x-cta.probestunde class="my-12" />

        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <img src="{{ $cdn . $page->image }}" alt="program" />
        </div>
    </x-container>
</div>
