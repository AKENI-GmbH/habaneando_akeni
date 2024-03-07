<?php

namespace App\Livewire\Frontend;

use App\Models\Course;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use Livewire\Component;

class HomeFrontPage extends Component
{
public function mount(){


  $course = Course::where('slug',  'nes-test-event')->first();

  dump(Carbon::now());
}
}
