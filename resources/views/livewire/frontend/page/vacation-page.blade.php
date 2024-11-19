<div>
    <x-hero :title="$page->name" :header="$page->header" />

    <x-container>
        <div class="mx-auto max-w-7xl px-6 text-center lg:px-8">

            <p>{!! $page->body !!}</p>
        </div>
    </x-container>
</div>
