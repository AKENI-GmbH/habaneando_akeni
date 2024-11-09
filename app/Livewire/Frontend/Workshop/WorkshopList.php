<?php

namespace App\Livewire\Frontend\Workshop;

use App\Enum\EventTypeEnum;
use App\Models\Event;
use Jenssegers\Date\Date;
use App\Traits\HasPage;
use Livewire\Component;

class WorkshopList extends Component
{
    use HasPage;

    protected $identifier = 'workshops';

    public $events;

    public function mount()
    {
        $this->events = Event::where('status', true)
        ->orderBy('date_from')
        ->where('date_to', '>', Date::now(3))
        ->where('event_type', EventTypeEnum::WORKSHOP)->get();
    }
}
