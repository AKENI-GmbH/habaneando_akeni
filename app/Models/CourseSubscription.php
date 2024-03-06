<?php

namespace App\Models;

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
    ];

    protected $casts = [
        'student' => 'boolean',
        'clubMember' => 'boolean',
        'numberOfMen' => 'integer',
        'numberOfWomen' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
