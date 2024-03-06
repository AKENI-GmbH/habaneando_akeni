<div>
    <x-hero :title="$page->name" :header="$page->header" />

    <x-container>
        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">

            @foreach ($events as $event)
                <x-event :event="$event" />
            @endforeach
        </div>
    </x-container>
</div>
