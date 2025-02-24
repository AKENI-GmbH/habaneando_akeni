<?php

namespace App\Livewire\Frontend\Checkout;

use Stripe\Checkout\Session as StripeCheckoutSession;
use App\Mail\PurchaseConfirmationEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\CourseSubscription;
use App\Enum\SubscriptionTypeEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use Livewire\Component;
use Stripe\Stripe;

class CourseCheckout extends Component
{
    public $session_id;

    public function mount($session_id)
    {
        $this->session_id = $session_id;
        $this->handleSuccessfulPayment();
    }

    private function handleSuccessfulPayment()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = StripeCheckoutSession::retrieve($this->session_id);
        $customer = auth()->guard('customer')->user();


        $existingSubscription = CourseSubscription::where([
            'transaction_id' => $this->session_id,
        ])->first();

        if ($existingSubscription) {
            return;
        }

        $subscription = CourseSubscription::create([
            'customer_id' => $checkout_session->metadata->customer_id,
            'course_id' => $checkout_session->metadata->course_id,
            'numberOfMen' => $checkout_session->metadata->quantityMen,
            'numberOfWomen' => $checkout_session->metadata->quantityWomen,
            'amount' => $checkout_session->amount_total / 100,
            'subscriptionType' => SubscriptionTypeEnum::SINGLE_PAYMENT,
            'method' => PaymentMethodEnum::STRIPE,
            'payment_status' => PaymentStatusEnum::ACCEPTED,
            'transaction_id' => $this->session_id,
        ]);

        Mail::to($checkout_session->customer_email)->send(new PurchaseConfirmationEmail($subscription));
    }

    public function render()
    {
        return view('livewire.frontend.checkout.checkout-success');
    }
}
