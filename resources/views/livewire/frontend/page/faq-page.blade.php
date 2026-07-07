<div>
    <x-hero :title="$page->name" :header="$page->header" />

    <x-container>
        {!! $page->body !!}
    </x-container>
</div>
