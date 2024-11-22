<?php

namespace App\Livewire\Customer;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public string $email;

    public function sendResetLink()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $status = Password::broker('customers')->sendResetLink(['email' => $this->email]);

        if ($status == Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
        } else {
            $this->addError('email', __($status));
        }
    }
    public function render()
    {
        return view('livewire.customer.forgot-password')->layout('components.layouts.auth');;
    }
}
