<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Traits\DateFormatting;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\CanResetPassword;

class Customer extends Authenticatable implements CanResetPassword
{

    use HasFactory, Notifiable, DateFormatting;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'birthday',
        'gender',
        'address',
        'address_aux',
        'city',
        'zip',
        'kontoinhaber',
        'IBAN',
        'BIC',
        'profession',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be formatted as dates.
     *
     * @var array
     */
    protected $dateAttributes = [
        'birthday',
    ];



    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'first_name',
        'last_name',
        'email',
        'updated_at',
        'created_at',
    ];



    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            if (!$customer->password) {
                $customer->password = Hash::make(Str::random(30));
            }
        });
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function clubMember()
    {
        return $this->hasOne(ClubMember::class);
    }

    public function courseSubscriptions()
    {
        return $this->hasMany(CourseSubscription::class, 'customer_id');
    }

    public function eventSubscriptions()
    {
        return $this->hasMany(EventSubscription::class, 'customer_id');
    }

    public function getBirthdayAttribute($birthday)
    {
        return $birthday ? Carbon::parse($birthday)->format('d-m-Y') : null;
    }

    public function setBirthdayAttribute($birthday)
    {
        $this->attributes['birthday'] = Carbon::parse($birthday)->format('Y-m-d');
    }

    public function getNameAttribute()
    {
        return $this->getFullNameAttribute();
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
