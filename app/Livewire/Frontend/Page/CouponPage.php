<?php

namespace App\Livewire\Frontend\Page;

use App\Models\Coupon;
use App\Traits\HasPage;
use Livewire\Component;

class CouponPage extends Component
{
    use HasPage;

    public $coupons;

    protected $identifier = 'gutscheine';

    public function mount()
    {
        $this->coupons = Coupon::where('active', true)->get();
    }
}
