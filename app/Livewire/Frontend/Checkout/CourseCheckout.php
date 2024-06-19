<?php

namespace App\Livewire\Frontend\Checkout;

use Livewire\Component;

class CourseCheckout extends Component
{
    public function mount($course)
    {
        dd($course);
    }

    public function render()
    {
        return view('livewire.frontend.checkout.course-checkout');
    }
}
