<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;

class RemoveCalendarID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:removeid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all calendar id from courses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $confirmed = $this->confirm('Are you sure you want to delete all entries?');

        if ($confirmed) {
            $courses = Course::withTrashed()->get();

            foreach ($courses as $course) {
                $course->update(['google_event_id' => null]);
            }

            $this->info('Done');
        } else {
            $this->info('Operation canceled.');
        }
    }
}
