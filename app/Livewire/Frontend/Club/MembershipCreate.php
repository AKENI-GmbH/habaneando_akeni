<?php

namespace App\Livewire\Frontend\Club;

use App\Models\RateCategory;
use App\Models\ClubRate;
use App\Traits\HasLogin;
use App\Traits\HasPage;
use Livewire\Component;

class MembershipCreate extends Component
{
    use HasLogin, HasPage;

    protected $identifier = "mitgliedschaft";

    public $page;
    public $rateCategory;
    public $selectedRate;
    public $selectedCategory;
    public $rate;
    public $selectableCourses = 0;
    public $showForm = true;

    public function mount()
    {
        $this->rateCategory = RateCategory::all();
        $this->selectedCategory = $this->rateCategory->first()->id ?? null;
        $this->selectedRate = optional($this->rateCategory->first()->activeRates->first())->id;
        $this->rate = ClubRate::find($this->selectedRate);

        if (auth()->guard('customer')->check()) {
            $this->customer = auth()->guard('customer')->user();
        }
    }

    public function updatedSelectedRate($rateId)
    {
        $this->selectedRate = $rateId;
        $this->rate = ClubRate::find($rateId);
        $this->selectableCourses = $this->rate->limit;
    }

    public function purchasePlan($rateId)
    {
        $selectedRate = ClubRate::find($rateId);

        if ($selectedRate) {
            session()->flash('success_message', 'Plan purchased successfully!');
            $this->showForm = false; // Hide the form after purchase
        }
    }

    public function render()
    {
        return view('livewire.frontend.club.membership-create', [
            'rateCategory' => $this->rateCategory,
            'selectedCategory' => $this->selectedCategory,
            'selectedRate' => $this->selectedRate,
            'rate' => $this->rate
        ]);
    }

    public function createMembership()
    {
    }
}
