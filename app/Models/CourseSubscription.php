<?php

namespace App\Models;

use App\Enum\SubscriptionTypeEnum;
use App\Enum\GenderEnum;
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
    ];

    protected $casts = [
        'student' => 'boolean',
        'clubMember' => 'boolean',
        'numberOfMen' => 'integer',
        'numberOfWomen' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($subscription) {
            if (empty($subscription->valid_to) && !empty($subscription->course->end_date)) {
                $subscription->valid_to = $subscription->course->end_date;
            }
        });

        static::creating(function ($subscription) {
            if ($subscription->subscriptionType === SubscriptionTypeEnum::MEMBERSHIP) {
                $subscription->clubMember = true;
            }

            if (empty($subscription->valid_to) && !empty($subscription->course->end_date)) {
                $subscription->valid_to = $subscription->course->end_date;
            }

            if (!$subscription->created_at) {
                $subscription->created_at = now();
            }

            if ($subscription->customer->gender === GenderEnum::MALE) {
                $subscription->numberOfMen = 1;
                $subscription->numberOfWomen = 0;
            } else {
                $subscription->numberOfMen = 0;
                $subscription->numberOfWomen = 1;
            }
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
        return empty($this->valid_to) || $this->valid_to > Now();
    }
}
