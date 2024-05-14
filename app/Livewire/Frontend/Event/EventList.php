<?php

namespace App\Livewire\Frontend\Event;

use App\Enum\EventTypeEnum;
use App\Models\Event;
use App\Traits\HasPage;
use Jenssegers\Date\Date;
use Livewire\Component;

class EventList extends Component
{
    use HasPage;

    protected $identifier = 'events';

    public $events;

    public function mount()
    {
        $this->events = Event::where('status', true)
            ->orderBy('date_from')
            ->where('date_to', '>', Date::now())
            ->where('event_type', EventTypeEnum::PARTY)->get();
    }
}
