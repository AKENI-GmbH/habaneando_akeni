<?php

namespace App\Livewire\Frontend\Checkout;

use App\Traits\HasPage;
use Livewire\Component;

class CheckoutCancel extends Component
{
    use HasPage;
    protected $identifier = "checkout-cancel";

    public function render()
    {
        return view('livewire.frontend.checkout.checkout-cancel');
    }
}
