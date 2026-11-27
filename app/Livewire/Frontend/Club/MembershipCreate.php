<?php

namespace App\Livewire\Frontend\Club;

use App\Enum\ClubMemberStatusEnum;
use App\Models\ClubMember;
use Livewire\Attributes\Validate;
use App\Models\RateCategory;
use App\Models\ClubRate;
use App\Models\Customer;
use App\Traits\HasLogin;
use App\Traits\HasPage;
use Livewire\Component;

class MembershipCreate extends Component
{
    use HasLogin, HasPage;

    protected $identifier = "mitgliedschaft";

    public $page;
    public $rateCategory;
    public $selectedRate = null;
    public $selectedCategory = null;
    public $rate = null;
    public $selectableCourses = 0;
    public $showForm = true;
    public $showSuccess = false;

    # Form fields
    #[Validate('required')]
    public $kontoinhaber = '';

    #[Validate('required')]
    public $iban = '';

    #[Validate('required')]
    public $bic = '';

    #[Validate('accepted')]
    public $termsAccepted = false;

    public function mount()
    {
        $this->rateCategory = RateCategory::all();
        $this->selectedCategory = $this->rateCategory->first()->id ?? null;
        $this->selectedRate = $this->rateCategory->first()->activeRates->first()->id ?? null;
        $this->updateRateInfo($this->selectedRate);

        if (auth()->guard('customer')->check()) {
            $this->customer = auth()->guard('customer')->user();
        }
    }

    public function updatedSelectedRate($rateId)
    {
        $this->updateRateInfo($rateId);
    }

    public function updateRateInfo($rateId)
    {
        $this->rate = ClubRate::find($rateId);
        $this->selectableCourses = $this->rate->limit ?? 0;
    }

    public function purchasePlan($rateId)
    {
        $selectedRate = ClubRate::find($rateId);

        if ($selectedRate) {
            $this->showForm = false;
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

        $customer = Customer::findOrFail($this->customer->id);
        $customer->update([
            'kontoinhaber' => $this->kontoinhaber,
            'IBAN' => $this->iban,
            'bic' => $this->bic,
        ]);

        $membership = ClubMember::create([
            'club_rate_id' => $this->rate->id,
            'customer_id' => $customer->id,
            'status' => ClubMemberStatusEnum::ACTIVE,
            'amount' => $this->rate->amount,
            'note' => $this->note ?? '',
        ]);

        $this->showSuccess = true;
    }
}
