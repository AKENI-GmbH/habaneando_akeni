<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateCategory extends Model
{
    use HasFactory;

    protected $fillable = ['position', 'name', 'duration'];
    
    protected $cast = [
        'duration' => 'integer',
    ];

    public function rates()
    {
        return $this->hasMany(ClubRate::class, 'rate_category_id');
    }

    public function activeRates()
    {
        return $this->hasMany(ClubRate::class, 'rate_category_id')->where('status', true);
    }
}
