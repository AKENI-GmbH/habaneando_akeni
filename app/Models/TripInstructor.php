<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;

class TripInstructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_edition_id',
        'thumbnail',
        'description'
    ];
}
