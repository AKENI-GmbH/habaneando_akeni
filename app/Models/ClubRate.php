<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubRate extends Model
{
  use HasFactory;

  protected $fillable = [
    'rate_category_id',
    'name',
    'amount',
    'limit',
    'description',
    'status'
  ];


  protected $casts = [
    'status' => 'bool'
  ];


  public function category()
  {
    return $this->belongsTo(RateCategory::class, 'rate_category_id');
  }

  public function getFullNameAttribute()
  {
    return $this->category->name . ': ' . $this->name;
  }

  public function clubMembers()
  {
    return $this->hasMany(ClubMember::class, 'club_rate_id');
  }
}
