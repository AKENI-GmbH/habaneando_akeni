<?php

namespace App\Livewire\Frontend\Crashcourse;

use App\Enum\EventTypeEnum;
use App\Models\Event;
use App\Traits\HasPage;
use Livewire\Component;
use Jenssegers\Date\Date;

class CrashCourseList extends Component
{
   use HasPage;

    protected $identifier = 'workshops';

    public $events;

    public function mount()
    {
        $this->events = Event::where('status', true)
        ->orderBy('date_from')
        ->where('date_to', '>', Date::now()->subday(3))
        ->where('event_type', EventTypeEnum::CRASHCOURSE)->get();
    }
}
