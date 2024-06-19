<?php

namespace App\Livewire\Frontend\Auth;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CustomerRegister extends Component
{
    public $user = [];

    public function mount()
    {
        $this->user = [
            'first_name' => "",
            'last_name' => "",
            'email' => "",
            'phone' => "",
            'password' => "",
            'password_confirmation' => "",
            'gender' => "",
            'day' => "",
            'month' => "",
            'year' => "",
            'address' => "",
            'city' => '',
            'zip' => '',
            'termsAccepted' => false,
        ];
    }

    public function register()
    {
        $this->validate([
            'user.first_name' => 'required|string|max:255',
            'user.last_name' => 'required|string|max:255',
            'user.email' => 'required|email|unique:customers,email',
            'user.phone' => 'nullable|string',
            'user.password' => 'required|string|min:6|confirmed',
            'user.password_confirmation' => 'required',
            'user.gender' => 'required|string',
            'user.address' => 'required|string',
            'user.city' => 'required|string',
            'user.zip' => 'required|string',
            'user.day' => 'required|numeric',
            'user.month' => 'required|numeric',
            'user.year' => 'required|numeric',
            'user.termsAccepted' => 'accepted',
        ], [
            'user.first_name.required' => 'Der Vorname ist erforderlich.',
            'user.last_name.required' => 'Der Nachname ist erforderlich.',
            'user.email.required' => 'Die E-Mail-Adresse ist erforderlich.',
            'user.email.email' => 'Geben Sie eine gültige E-Mail-Adresse ein.',
            'user.email.unique' => 'Diese E-Mail-Adresse ist bereits vergeben.',
            'user.phone.string' => 'Die Telefonnummer muss ein String sein.',
            'user.password.required' => 'Das Passwort ist erforderlich.',
            'user.password.min' => 'Das Passwort muss mindestens 6 Zeichen lang sein.',
            'user.password.confirmed' => 'Die Passwortbestätigung stimmt nicht überein.',
            'user.gender.required' => 'Das Geschlecht ist erforderlich.',
            'user.address.required' => 'Die Adresse ist erforderlich.',
            'user.city.required' => 'Die Stadt ist erforderlich.',
            'user.zip.required' => 'Die Postleitzahl ist erforderlich.',
            'user.day.required' => 'Der Tag ist erforderlich.',
            'user.month.required' => 'Der Monat ist erforderlich.',
            'user.year.required' => 'Das Jahr ist erforderlich.',
            'user.termsAccepted.accepted' => 'Sie müssen den Allgemeinen Geschäftsbedingungen (AGB) und den Datenschutzbestimmungen zustimmen.',
        ]);

        $birthday = $this->user['year'] . '-' . $this->user['month'] . '-' . $this->user['day'];

        $age = now()->diffInYears(\Carbon\Carbon::parse($birthday));

        if ($age < 16) {
            return redirect()->back();
        }

        $customer = Customer::create([
            'first_name' => $this->user['first_name'],
            'last_name' => $this->user['last_name'],
            'email' => $this->user['email'],
            'phone' => $this->user['phone'],
            'password' => Hash::make($this->user['password']),
            'birthday' => $birthday,
            'address' => $this->user['address'],
            'city' => $this->user['city'],
            'zip' => $this->user['zip'],
            'gender' => $this->user['gender'],
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->intended(route('frontend.konto'));
    }

    public function render()
    {
        return view('livewire.frontend.auth.customer-register')->layout('components.layouts.auth');
    }
}
