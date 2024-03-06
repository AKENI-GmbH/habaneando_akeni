<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DateFormatting;

class Ticket extends Model
{
    use HasFactory, DateFormatting;

    protected $fillable = [
        'ticket_type_id',
        'name',
        'amount',
        'valid_date_from',
        'valid_date_until',
    ];

 
    /**
     * The attributes that should be formatted as dates.
     *
     * @var array
     */
    protected $dateAttributes = [
        'valid_date_from',
        'valid_date_until',
    ];

    public function subscriptions()
    {
        return $this->hasMany(EventSubscription::class, 'ticket_id');
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }
}
