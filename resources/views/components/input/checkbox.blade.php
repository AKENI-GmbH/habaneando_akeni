@props([
    'label' => false,
    'error' => false,
    'id' => 'checkbox-' . Illuminate\Support\Str::random(),
])

<div class="space-y-2">
    <div class="relative flex items-start">
        <div class="flex h-6 items-center">
            <input {{ $attributes->merge(['id' => $id]) }} aria-describedby="candidates-description" name="candidates"
                type="checkbox" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-600">
        </div>
        <div class="ml-3 text-sm leading-6">
            <label for="{{ $id }}" class="font-medium text-gray-900">{!! $label !!}</label>
        </div>
    </div>

    @if ($error)
        <div class="mt-1 text-red-500 text-sm">{{ $error }}</div>
    @endif
</div>
