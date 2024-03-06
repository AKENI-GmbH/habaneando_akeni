@props(['identifier'])

<div x-show="activeTab === '{{ $identifier }}'" id="tab-panel-reviews" class="-mb-10"
    aria-labelledby="{{ $identifier }}" role="tabpanel" tabindex="0">{{ $slot }}</div>
