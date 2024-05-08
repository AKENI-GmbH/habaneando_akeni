<?php

namespace App\Livewire\Page;

use App\Models\Coupon;
use App\Models\Page;
use Livewire\Component;

class CouponSingle extends Component
{
    public $coupon;
    public $header;

    public function mount(Coupon $slug)
    {
        $this->header = Page::where('identifier', 'gutscheine')->first()->header;
        $this->coupon = $slug;
    }
}
