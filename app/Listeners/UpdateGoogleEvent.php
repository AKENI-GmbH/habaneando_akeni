<?php

namespace App\Listeners;

use App\Events\CourseUpdated;
use Spatie\GoogleCalendar\Event;

class UpdateGoogleEvent
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
    public function handle(CourseUpdated $event): void
    {
        $course = $event->course;

        if ($course->google_event_id) {
            $google_event = Event::find($course->google_event_id);

            $google_event->update([
                'name' => $course->name,
                'startDateTime' => \Carbon\Carbon::parse($course->start_date)->addHour($course->schedule_time_from),
                'endDateTime' => \Carbon\Carbon::parse($course->start_date)->addHour($course->schedule_time_from),
            ]);
        }
    }
}
