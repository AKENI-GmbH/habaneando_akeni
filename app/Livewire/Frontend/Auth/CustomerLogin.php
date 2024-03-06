<?php

namespace App\Livewire\Frontend\Auth;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerLogin extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $this->email)->first();

        if (!$customer) {
            session()->flash('error', 'The email does not exist.');
            return;
        }

        if (!Auth::guard('customer')->attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('error', 'Invalid password.');
            return;
        }

        return redirect()->intended(route('frontend.konto'));
    }


    public function render()
    {
        return view('livewire.frontend.auth.customer-login')
            ->layout('components.layouts.auth');
    }
}
