<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;

class syncCourseHeader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:sync-header';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $coruses = Course::all();
        foreach ($coruses as $course) {
            if (!$course->header()->exists()) {
                $header = $course->header()->create();

                if ($header->exists()) {
                    $this->info('Created');
                }
            }
        }
    }
}
