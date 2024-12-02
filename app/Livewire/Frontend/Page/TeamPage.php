<?php

namespace App\Livewire\Frontend\Page;

use App\Models\Teacher;
use App\Traits\HasPage;
use Livewire\Component;

class TeamPage extends Component
{
    use HasPage;

    protected $identifier = 'team';

    public $members;

    public function mount()
    {
        $this->members = Teacher::where('is_staff', true)->orderBy('id')->get();
    }
}
