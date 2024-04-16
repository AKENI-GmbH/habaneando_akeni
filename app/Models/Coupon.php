<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', //Navidad -> admin
        'image', //Navidad -> admin
        'recipient', // Recipient -> customer
        'price',
    ];
}
