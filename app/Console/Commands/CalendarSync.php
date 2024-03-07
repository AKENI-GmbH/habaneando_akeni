<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\GoogleCalendar\Event;
use App\Models\Course;
use Carbon\Carbon;

class CalendarSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add missing courses to calendar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $courses = Course::where('google_event_id', null)->get();

        foreach ($courses as $course) {
            $event = Event::create([
                'name' => $course->name,
                'startDateTime' => Carbon::parse($course->start_date . ' ' . $course->schedule_time_from),
                'endDateTime' => Carbon::parse($course->start_date . ' ' . $course->schedule_time_to),
            ]);

            $course->update(['google_event_id' => $event->id]);

            $this->info("Updated course: {$course->name} with event {$event->id}");
        }
    }
}
