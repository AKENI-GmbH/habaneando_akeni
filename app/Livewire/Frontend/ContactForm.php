<?php

namespace App\Livewire\Frontend;

use App\Models\ContactMessage;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $email = '';

    #[Validate('required')]
    public $subject = '';

    #[Validate('required')]
    public $message = '';

    public function save()
    {
        $this->validate();

        ContactMessage::create(
            $this->only(['name', 'email', 'subject', 'message'])
        );
    }
}
