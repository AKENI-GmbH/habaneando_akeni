@props(['default', 'buttons', 'content'])

@props(['default'])
<div x-data="{ activeTab: '{{ $default }}' }" class="mt-0 w-full max-w-2xl lg:col-span-4 lg:mt-0 lg:max-w-none">
    <div>
        <div class="border-b border-gray-200">
            <div class="-mb-px flex space-x-8" aria-orientation="horizontal" role="tablist">

                <div class="flex">
                    {{ $buttons }}
                </div>
            </div>
        </div>

        <div class="pt-3">
            {{ $content }}
        </div>
    </div>
</div>
