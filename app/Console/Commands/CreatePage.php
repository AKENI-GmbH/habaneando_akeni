<?php

namespace App\Console\Commands;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Models\Page;

class CreatePage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page:create {name : The name of the page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new page';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $slug = Str::slug($name);

        $identifier = strtolower($slug);

        $page = Page::create([
            'name' => $name,
            'identifier' => $identifier,
        ]);

        $page->header()->create();

        // Output success message
        $this->info("Page '{$name}' created successfully.");
    }
}
