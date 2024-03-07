<?php

namespace App\Console\Commands;

use App\Models\Course;
use Spatie\GoogleCalendar\Event;
use Illuminate\Console\Command;

class CalendarRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:remove {id? : ID of the entry to remove} {--all : Remove all entries}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove calendar entries';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->removeEvents();
    }

    protected function removeEvents()
    {
        $id = $this->argument('id');
        $allOption = $this->option('all');

        if ($id && !$allOption) {
            $confirmed = $this->confirm('Are you sure you want to delete event with ID ' . $id . '?');
            if ($confirmed) {
                $this->info('Deleting entry with ID ' . $id . '...');
                $event = Event::find($id);
                $event->delete();
                $this->info('Event with ID ' . $id . ' deleted successfully.');
            } else {
                $this->info('Operation canceled.');
            }
        } elseif ($allOption) {
            $confirmed = $this->confirm('Are you sure you want to delete all entries?');
            if ($confirmed) {
                $events = Event::get();
                $totalEvents = $events->count();

                $this->info("Deleting $totalEvents events...");

                foreach ($events as $event) {
                    $event->delete();
                }

                $this->removeIds();

                $this->info("All events deleted successfully.");
            } else {
                $this->info('Operation canceled.');
            }
        } else {
            $this->info('Please specify an ID or use --all flag.');
        }
    }

    protected function removeIds()
    {

        $courses = Course::withTrashed()->get();

        foreach ($courses as $course) {
            $course->update(['google_event_id' => null]);
        }
    }
}
