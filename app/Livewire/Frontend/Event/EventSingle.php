<?php

namespace App\Livewire\Frontend\Event;

use App\Models\Event;
use App\Traits\HasLogin;
use Livewire\Component;

class EventSingle extends Component
{
    use HasLogin;


    /**
     *@var Event
     */
    public $event;

    public $routePath;


    public function mount(Event $event)
    {
        $this->event = $event;
        $this->routePath = route('frontend.event.single', $event);
    }
}
