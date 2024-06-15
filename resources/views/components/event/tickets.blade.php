@props(['event'])
<div>
    @if ($event->ticketType)
    <x-input.group for="ticket" label="Tickets">
     <x-input.select wire:model="ticket">
         @foreach ($event->ticketType->tickets as $ticket)
             <option value="{{ $ticket->id }}">{{ $ticket->name }}</option>
         @endforeach
     </x-input.select>
 </x-input.group>
    @endif
</div>
