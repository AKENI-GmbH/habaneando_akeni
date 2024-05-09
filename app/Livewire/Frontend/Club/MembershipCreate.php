<?php

namespace App\Livewire\Frontend\Club;

use App\Models\ClubRate;
use App\Models\CourseSubcategory;
use App\Models\RateCategory;
use App\Traits\HasLogin;
use App\Traits\HasPage;
use Livewire\Component;

class MembershipCreate extends Component
{
    use HasLogin, HasPage;

    protected $identifier = "mitgliedschaft";

    public $page;
    public $rateCategory;
    public $selectedRate = 1;

    public function mount()
    {
        $this->rateCategory = RateCategory::all();
    }

    public function purchasePlan($rateId)
    {
        $selectedRate = ClubRate::find($rateId);

        if ($selectedRate) {
            session()->flash('success_message', 'Plan purchased successfully!');
        }
    }
}
