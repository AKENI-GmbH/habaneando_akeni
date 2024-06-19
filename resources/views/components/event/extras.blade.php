@props(['extras' => []])
<div class="overflow-x-auto">
    <table class="table-auto min-w-full">
        <tbody>
            @foreach ($extras as $extra)
            <tr class="border-b border-neutral-200">
                <td class="px-4 py-2 whitespace-nowrap">{{ $extra['key'] }}</td>
                <td class="px-4 py-2 whitespace-nowrap">{{ $extra['value'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
