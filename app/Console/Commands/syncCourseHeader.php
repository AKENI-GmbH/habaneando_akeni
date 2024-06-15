<?php

namespace App\Console\Commands;

use App\Models\Event;
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
        $events = Event::all();
        foreach ($events as $event) {
            if (!$event->header()->exists()) {
                $header = $event->header()->create();

                if ($header->exists()) {
                    $this->info('Created');
                }
            }
        }
    }
}
