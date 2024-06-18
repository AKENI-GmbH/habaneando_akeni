<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClubMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'membership_id',
        'customer_id',
        'club_rate_id',
        'status',
        'valid_date_until',
        'amount',
        'note',
        'created_at'
    ];


    protected static function boot()
    {
        parent::boot();

        static::updating(function ($clubMember) {

            if (empty($clubMember->amount) || $clubMember->amount <= 0) {
                $clubMember->amount = $clubMember->clubRate->amount;
            }

            $duration = $clubMember->clubRate->category->duration;
            $clubMember->valid_date_until = Carbon::parse($clubMember->created_at)->addYear($duration);
        });

        static::creating(function ($clubMember) {
            if (empty($clubMember->membership_id)) {
                $membershipId = $clubMember->customer_id . $clubMember->club_rate_id . now()->format('ymd');
                $clubMember->membership_id = $membershipId;
            }

            if (empty($clubMember->amount) || $clubMember->amount <= 0) {
                $clubMember->amount = $clubMember->clubRate->amount;
            }

            if (!$clubMember->created_at) {
                $clubMember->created_at = now();
            }

            if (empty($clubMember->valid_date_until)) {
                $duration = $clubMember->clubRate->category->duration;
                $clubMember->valid_date_until = Carbon::parse($clubMember->created_at)->addYear($duration);
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function clubRate()
    {
        return $this->belongsTo(ClubRate::class, 'club_rate_id');
    }

    public function getPriceAttribute()
    {
        return  number_format($this->amount, 2, ',', '.') . '€';
    }

    public function getDeadlineAttribute()
    {
        // dump($this);
        return Carbon::parse($this->valid_date_until)->subMonth(1);
    }
}
