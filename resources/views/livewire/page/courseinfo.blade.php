<div>
    <x-hero :title="$page->name" :header="$page->header" />
    <x-container>
        <div>
            {!! $page->body !!}
        </div>
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <img src="{{ $page->image }}" alt="program" />
        </div>
    </x-container>
</div>
