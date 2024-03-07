<?php

namespace App\Listeners;

use App\Events\CourseUpdated;
use Carbon\Carbon;
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

        $data = [
            'name' => $course->name,
            'startDateTime' => Carbon::parse($course->start_date . ' ' . $course->schedule_time_from),
            'endDateTime' => Carbon::parse($course->start_date . ' ' . $course->schedule_time_to),
        ];

        $google_event = Event::find($course->google_event_id);
        $google_event->update($data);

        $course->update(['google_event_id' => $google_event->id]);
    }
}
