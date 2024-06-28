<?php

namespace App\Livewire\Frontend\Event;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\SubscriptionTypeEnum;
use Stripe\Checkout\Session as StripeCheckoutSession;
use App\Traits\HasLogin;
use Livewire\Component;
use App\Models\Event;
use App\Models\EventSubscription;
use App\Models\Ticket;
use Stripe\Stripe;
use Carbon\Carbon;

class EventSingle extends Component
{
    use HasLogin;

    public $event;
    public $routePath;
    public $ticket;
    public $quantity = 1;
    public $tickets = [];

    public function mount(Event $event)
    {
        $this->event = $event->load('ticketType.tickets');
        $this->routePath = route('frontend.event.single', $event);

        if (auth()->guard('customer')->check()) {
            $this->customer = auth()->guard('customer')->user();
        }

        $currentDate = Carbon::now()->format('Y-m-d');

        $this->tickets = $this->event->ticketType->tickets->filter(function($ticket) use ($currentDate) {
            $validDateFrom = Carbon::parse($ticket->valid_date_from)->format('Y-m-d');
            $validDateUntil = Carbon::parse($ticket->valid_date_until)->format('Y-m-d');
            return $validDateFrom <= $currentDate && $validDateUntil >= $currentDate;
        });

    }

    public function createSession()
    {
        $this->validateInput();
        $checkoutUrl = $this->createCheckoutSession();
        return redirect()->away($checkoutUrl);
    }

    private function createCheckoutSession()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $appUrl = env('APP_URL');
        $ticket = Ticket::find($this->ticket);

        $checkout_session = StripeCheckoutSession::create([
            'payment_method_types' => ['card', 'sepa_debit'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $this->event->name,
                    ],
                    'unit_amount' => $ticket->amount * 100,
                ],
                'quantity' => $this->quantity,
            ]],
            'billing_address_collection' => 'required',
            'customer_email' => $this->customer->email,
            'mode' => 'payment',
            'locale' => 'de',
            'success_url' => $appUrl . '/checkout/success',
            'cancel_url' => $appUrl . '/checkout/cancel',
        ]);

        $amount = $this->quantity * $ticket->amount;
        $this->createSubscription($this->customer, $amount);

        return $checkout_session->url;
    }

    private function validateInput()
    {
        $rules = [
            'quantity' => 'required|integer|min:0',
            'ticket' => 'required',
        ];

        $messages = [
            'quantity.required' => 'Bitte geben Sie die Menge an.',
            'ticket.required' => 'Bitte wählen Sie ein Ticket aus',
        ];

        $this->validate($rules, $messages);
    }

    private function createSubscription($customer, $amount)
    {
        EventSubscription::create([
            'ticket_id' => $this->ticket,
            'customer_id' => $customer->id,
            'event_id' => $this->event->id,
            'numberOfMen' => $this->quantity,
            'numberOfWomen' => 0,
            'clubMember' => false,
            'subscriptionType' => SubscriptionTypeEnum::SINGLE_PAYMENT,
            'amount' => $amount,
            'method' => PaymentMethodEnum::TRANSFER,
            'payment_status' => PaymentStatusEnum::PENDING
        ]);
    }

    public function render()
    {
        return view('livewire.frontend.event.event-single', [
            'event' => $this->event,
            'tickets' => $this->tickets,
        ]);
    }
}
