<?php

namespace App\Livewire\Frontend;

use App\Models\ContactMessage;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    public bool $sent = false;

    #[Validate('required')]
    public $name = '';

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $subject = '';

    #[Validate('required')]
    public $message = '';

    public function save()
    {
        $data = $this->validate();

        $this->sent = true;

        ContactMessage::create(
            $this->only(['name', 'email', 'subject', 'message'])
        );
    }
}
