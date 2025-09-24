<?php

namespace App\Livewire\Frontend\Checkout;

use Stripe\Checkout\Session as StripeCheckoutSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Enum\SubscriptionTypeEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Mail\EventPurchaseConfirmationEmail;
use App\Models\EventSubscription;
use Livewire\Component;
use Stripe\Stripe;

class CheckoutSuccess extends Component
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
  $customer = Auth::guard('customer')->user();

  $existingSubscription = EventSubscription::where([
   'customer_id' => $customer->id,
   'event_id' => $checkout_session->metadata->event_id,
   'ticket_id' => $checkout_session->metadata->ticket_id,
   'tickets' => $checkout_session->metadata->quantity
  ])->first();

  if ($existingSubscription) {
   return;
  }

  $subscription = EventSubscription::create([
   'customer_id' => $customer->id,
   'event_id' => $checkout_session->metadata->event_id,
   'ticket_id' => $checkout_session->metadata->ticket_id,
   'tickets' => $checkout_session->metadata->quantity,
   'numberOfMen' => $checkout_session->metadata->quantityMen,
   'numberOfWomen' => $checkout_session->metadata->quantityWomen,
   'amount' => $checkout_session->amount_total / 100,
   'subscriptionType' => SubscriptionTypeEnum::SINGLE_PAYMENT,
   'method' => PaymentMethodEnum::STRIPE,
   'payment_status' => PaymentStatusEnum::ACCEPTED
  ]);

  Mail::to($checkout_session->customer_email)->send(new EventPurchaseConfirmationEmail($subscription));
 }

 public function render()
 {
  return view('livewire.frontend.checkout.checkout-success');
 }
}
