<?php

namespace App\Livewire;

use App\Models\Page;
use Livewire\Component;

class DefaultPage extends Component
{
     /**
     * The page model instance.
     *
     * @var ModelsPage|null
     */
    public $page;

    /**
     * Mount the component.
     *
     * @param  string  $slug
     * @return void
     */
    public function mount($slug)
    {
        $this->page = Page::where('slug', $slug)->first();


        if (!$this->page) {
            abort(404);
        }
    }

}
