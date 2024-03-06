<?php

namespace App\Livewire\Frontend\Course;

use Stripe\Exception\InvalidRequestException;
use Stripe\Checkout\Session as StripeCheckoutSession;
use App\Models\ClubRate;
use App\Traits\HasLogin;
use Livewire\Component;
use App\Models\Course;
use Stripe\Stripe;

class CoursesShow extends Component
{
    use HasLogin;

    public $course;
    public $header;
    public $price;
    public $quantityMen = 0;
    public $quantityWomen = 0;
    public $totalPrice;
    public $routePath;
    public $minClubPrice = 0;


    public function mount(Course $course)
    {
        $this->course = $course->load('subcategory.category', 'location');
        $this->price = $this->course->subcategory->amount;
        $this->calculateTotalPrice();
        $this->routePath = route('frontend.course.show', $course);
        $this->minClubPrice = ClubRate::min('amount');

        if (auth()->guard('customer')->check()) {
            // Customer is logged in, return the customer
            $this->customer = auth()->guard('customer')->user();
        }
    }

    public function updatedQuantityMen()
    {
        $this->calculateTotalPrice();
    }

    public function updatedQuantityWomen()
    {
        $this->calculateTotalPrice();
    }

    private function calculateTotalPrice()
    {
        $this->totalPrice = ($this->quantityMen + $this->quantityWomen) * $this->price;
    }

    public function createSession()
    {
        // Validate input
        $this->validateInput();

        if ($this->quantityMen == 0 && $this->quantityWomen == 0) {
            return;
        }

        try {
            $checkoutUrl = $this->createCheckoutSession();
            return redirect()->away($checkoutUrl);
        } catch (InvalidRequestException $e) {
            $this->addError('quantityMen', $e->getMessage());
        }
    }

    private function validateInput()
    {
        $rules = [
            'quantityMen' => 'required|integer|min:0',
            'quantityWomen' => 'required|integer|min:0',
        ];

        $messages = [
            'quantityMen.min' => 'Mindestens ein Teilnehmer ist erforderlich.',
            'quantityWomen.min' => 'Mindestens ein Teilnehmer ist erforderlich.',
            'quantityMen.required' => 'Mindestens ein Teilnehmer ist erforderlich.',
            'quantityWomen.required' => 'Mindestens ein Teilnehmer ist erforderlich.',
        ];

        $this->validate($rules, $messages);


        if ($this->quantityMen == 0 && $this->quantityWomen == 0) {
            $this->addError('quantityMen', 'Mindestens ein Teilnehmer ist erforderlich.');
        }
    }


    private function createCheckoutSession()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $appUrl = env('APP_URL');

        $checkout_session = StripeCheckoutSession::create([
            'payment_method_types' => ['card', 'sepa_debit'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $this->course->subcategory->category->name . ' ' . $this->course->name,
                    ],
                    'unit_amount' => $this->course->subcategory->amount * 100,
                ],
                'quantity' => $this->quantityMen + $this->quantityWomen,
            ]],
            'billing_address_collection' => 'required',
            'customer_email' => $this->customer->email,
            'mode' => 'payment',
            'locale' => 'de',
            'success_url' => $appUrl . '/checkout/success',
            'cancel_url' => $appUrl . '/checkout/cancel',
        ]);

        return $checkout_session->url;
    }
}
