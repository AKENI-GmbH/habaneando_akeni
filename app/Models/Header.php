<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use HasFactory;

    protected $fillable = [
        'cover',
        'videoId',
        'mediaType',
        'caption',
        'overlay',
        'overlayColor',
        'textColor',
        'overlayOpacity',
    ];

    protected $casts = [
        'caption' => 'boolean',
        'overlay' => 'boolean',
    ];

    public function headerable()
    {
        return $this->morphTo();
    }
}
