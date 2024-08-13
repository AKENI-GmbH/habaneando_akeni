<?php

namespace App\Livewire\Frontend\Auth;

use App\Enum\ClubMemberStatusEnum;
use App\Traits\HasPage;
use Livewire\Component;

class CustomerDashboard extends Component
{
   use HasPage;

   protected $identifier = "customer-konto";

   public $customer;
   public $activeTab = 'my-account';
   public $membership = null;

   public function setActiveTab($tab)
   {
      $this->activeTab = $tab;

      if ($this->customer->clubMember) {
         $this->membership = $this->customer->clubMember->where('status', ClubMemberStatusEnum::ACTIVE)->first();
      }
   }

   public function mount()
   {
      $this->customer = auth()->guard('customer')->user();
   }
   public function render()
   {

      return view('livewire.frontend.auth.customer-dashboard', [
         'activeTab' => $this->activeTab,
      ]);
   }
}
