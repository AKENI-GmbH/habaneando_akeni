<?php

namespace App\Listeners;

use App\Events\CourseCreated;
use Spatie\GoogleCalendar\Event;

class CreateGoogleEvent
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
    public function handle(CourseCreated $event): void
    {
        $course = $event->course;


        $gEvent = Event::create([
            'name' => $course->name,
            'startDateTime' => \Carbon\Carbon::parse($course->start_date)->addHour($course->schedule_time_from),
            'endDateTime' => \Carbon\Carbon::parse($course->start_date)->addHour($course->schedule_time_from),
        ]);

        $course->update(['google_event_id' => $gEvent->id]);
    }
}
