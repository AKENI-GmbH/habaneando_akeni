<?php

namespace App\Livewire\Customer;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class ResetPassword extends Component
{
    public $email;
    public $password;
    public $password_confirmation;
    public $token;

    public function resetPassword()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($customer, string $password) {
                $customer->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $customer->save();

                event(new PasswordReset($customer));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->intended(route('frontend.login'));
        } else {
            $this->addError('email', __($status));
        }
    }

    public function render()
    {
        return view('livewire.customer.reset-password');
    }
}
