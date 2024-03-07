<?php

namespace App\Listeners;

use App\Events\CourseCreated;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;


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
            'startDateTime' => Carbon::parse($course->start_date . ' ' . $course->schedule_time_from),
            'endDateTime' => Carbon::parse($course->start_date . ' ' . $course->schedule_time_to),
        ]);

        $course->update(['google_event_id' => $gEvent->id]);
    }
}
