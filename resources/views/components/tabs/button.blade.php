@props(['identifier', 'label'])

<button @click="activeTab = '{{ $identifier }}'"
    :class="{ 'bg-red-600 text-white': activeTab === '{{$identifier}}', 'bg-neutral-200 text-black': activeTab !== '{{ $identifier }}' }"
    aria-controls="tab-panel-reviews" role="tab" type="button"
    class="inline-flex items-center px-6 py-3 rounded-tl-md rounded-tr-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:tracking-widest">
    <span class="uppercase">{{$label}}</span>
</button>
