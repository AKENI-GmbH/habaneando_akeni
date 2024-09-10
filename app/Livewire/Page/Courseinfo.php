<?php

namespace App\Livewire\Page;

use App\Traits\HasPage;
use Livewire\Component;

class Courseinfo extends Component
{
    use HasPage; 

    public $cdn;

    public function mount() {
        $this->cdn = env("DO_CDN") . '/';
    }

    protected $identifier = 'courseinfo';
}
