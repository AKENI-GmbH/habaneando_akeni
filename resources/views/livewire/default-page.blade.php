@section('title', $page->name)
<div>
    <x-hero :title="$page->name" :header="$page->header" />

    <div class="bg-white px-6 py-24 lg:px-8">
        <div class="mx-auto max-w-3xl text-base leading-7 text-neutral-700">
            {!! $page->body !!}
        </div>
    </div>
</div>
