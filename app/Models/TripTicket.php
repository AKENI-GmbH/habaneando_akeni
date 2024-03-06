<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TripTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_type_id',
        'trip_edition_id',
        'amount',
        'valid_date_from',
        'valid_date_until'
    ];

    public function type()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }
    public function edition()
    {
        return $this->belongsTo(TripEdition::class, 'trip_edition_id');
    }
}
