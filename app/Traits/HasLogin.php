<?php

declare(strict_types=1);

namespace App\Traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Models\Customer;

trait HasLogin
{
    public $customer;

    public $login = [
        'email' => null,
        'password' => null,
    ];

    public function customerLogin(): Response
    {
        $this->validate([
            'login.email' => 'required|email',
            'login.password' => 'required',
        ]);

        $customer = Customer::where('email', $this->login['email'])->first();

        if (!$customer) {
            session()->flash('error', 'Benutzer existiert nicht.');
            // return response()->redirectToRoute($this->routePath);
        }

        if (!Auth::guard('customer')->attempt([
            'email' => $this->login['email'],
            'password' => $this->login['password']
        ])) {
            session()->flash('error', 'Ungültige Anmeldeinformationen. Bitte versuchen Sie es erneut.');
        }

        $this->customer = auth()->guard('customer')->user();

        $this->dispatch('loggedIn');

        return response(
            <<<EOF
            <script>
                window.location.reload();
            </script>
        EOF
        );
    }
}
