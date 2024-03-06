<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_edition_id',
        'thumbnail'
    ];
}
