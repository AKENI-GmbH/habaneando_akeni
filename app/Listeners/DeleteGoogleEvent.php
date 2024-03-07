<?php

namespace App\Listeners;

use App\Events\CourseDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\GoogleCalendar\Event;

class DeleteGoogleEvent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CourseDeleted $event): void
    {
        $course = $event->course;

        if(!$course->google_event_id) return;

        $google_event = Event::find($course->google_event_id);

        $google_event->delete();
    }
}
