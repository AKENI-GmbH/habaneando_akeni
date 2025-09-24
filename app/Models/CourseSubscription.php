<?php

namespace App\Models;

use App\Enum\SubscriptionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'course_id',
        'student',
        'numberOfMen',
        'numberOfWomen',
        'clubMember',
        'subscriptionType',
        'amount',
        'fee',
        'method',
        'payment_status',
        'valid_to',
        'transaction_id',
    ];

    protected $casts = [
        'student'       => 'boolean',
        'clubMember'    => 'boolean',
        'numberOfMen'   => 'integer',
        'numberOfWomen' => 'integer',
        'valid_to'      => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscription) {
            if ($subscription->subscriptionType === SubscriptionTypeEnum::MEMBERSHIP) {
                $subscription->clubMember = true;
            }

            if (is_null($subscription->valid_to) && !empty($subscription->course?->end_date)) {
                $subscription->valid_to = $subscription->course->end_date;
            }

            $subscription->numberOfMen   = max(0, (int) ($subscription->numberOfMen   ?? 0));
            $subscription->numberOfWomen = max(0, (int) ($subscription->numberOfWomen ?? 0));
        });

        static::updating(function ($subscription) {
            if (is_null($subscription->valid_to) && !empty($subscription->course?->end_date)) {
                $subscription->valid_to = $subscription->course->end_date;
            }

            $subscription->numberOfMen   = max(0, (int) ($subscription->numberOfMen   ?? 0));
            $subscription->numberOfWomen = max(0, (int) ($subscription->numberOfWomen ?? 0));
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function getIsActiveAttribute()
    {
        return is_null($this->valid_to) || $this->valid_to > now();
    }
}
