<?php

namespace App\Livewire\Frontend\Checkout;

use Stripe\Checkout\Session as StripeCheckoutSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use App\Enum\PaymentMethodEnum;
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

    if (($checkout_session->payment_status ?? null) !== 'paid') {
   return;
  }

    $authenticatedCustomer = Auth::guard('customer')->user();
    $customerIdFromMetadata = $checkout_session->metadata->customer_id ?? null;

    if ($customerIdFromMetadata) {
     $customer = Customer::find($customerIdFromMetadata);
    } else {
     $customer = $authenticatedCustomer;
    }

    if (!$customer) {
     return;
    }

    if ($authenticatedCustomer && (int) $authenticatedCustomer->id !== (int) $customer->id) {
     return;
    }

  // One Stripe checkout session = one subscription. Reloading this page
  // (refresh, back button, in-app browsers) must not create duplicates.
  $subscription = EventSubscription::createOrFirst(
   ['stripe_session_id' => $checkout_session->id],
   [
    'customer_id' => $customer->id,
    'event_id' => $checkout_session->metadata->event_id,
    'ticket_id' => $checkout_session->metadata->ticket_id,
    'tickets' => (int) $checkout_session->metadata->quantity,
    'amount' => $checkout_session->amount_total / 100,
    'method' => PaymentMethodEnum::STRIPE,
   ]
  );

  if (!$subscription->wasRecentlyCreated) {
   return;
  }

  Mail::to($checkout_session->customer_email)->send(new EventPurchaseConfirmationEmail($subscription));
 }

 public function render()
 {
  return view('livewire.frontend.checkout.checkout-success');
 }
}
