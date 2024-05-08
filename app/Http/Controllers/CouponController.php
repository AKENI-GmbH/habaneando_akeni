<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function preview()
    {
        $data = [
            'recipientName' => 'John Doe',
            'couponAmount' => 50,
            'expiryDate' => '2024-06-30',
            'giftMessage' => 'Happy Birthday! Enjoy this gift coupon!'
        ];

        return view('coupon.preview', $data);
    }
}
