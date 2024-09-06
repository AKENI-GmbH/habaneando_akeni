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

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status == Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
        } else {
            $this->addError('email', __($status));
        }
    }
    
    // public function sendResetLink()
    // {
    //     $this->validate([
    //         'email' => 'required|email'
    //     ]);

    //     $status = Password::sendResetLink(['email' => $this->email]);

    //     if ($status === Password::RESET_LINK_SENT) {
    //         session()->flash('status', __('Ein Link zum Zurücksetzen des Passworts wurde an Ihre E-Mail-Adresse gesendet.'));
    //     } else {
    //         session()->flash('error', __('Wir konnten keinen Benutzer mit dieser E-Mail-Adresse finden'));
    //     }
    // }
    public function render()
    {
        return view('livewire.customer.forgot-password')->layout('components.layouts.auth');;
    }
}
