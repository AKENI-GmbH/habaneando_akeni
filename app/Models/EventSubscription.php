<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'event_id',
        'ticket_id',
        'tickets',
        'numberOfMen',
        'numberOfWomen',
        'amount',
        'fee',
        'method',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();


        static::creating(function ($subscription) {
            $subscription->tickets = $subscription->numberOfMen + $subscription->numberOfWomen;
            $subscription->amount =  $subscription->ticket->amount * ($subscription->numberOfMen + $subscription->numberOfWomen);
            $subscription->status = true;
        });
    }

    public function event(){
        return $this->belongsTo(Event::class, 'event_id');
    }
    public function edition()
    {
        return $this->belongsTo(Edition::class, 'edition_id');
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
