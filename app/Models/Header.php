<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use HasFactory;

    protected $fillable = [
        'cover', 'videoId', 'mediaType', 'caption', 'overlay', 'overlayColor', 'textColor', 'overlayOpacity',
    ];

    protected $casts = [
        'caption' => 'boolean',
        'overlay' => 'boolean',
    ];

    public function headerable()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($header) {
            self::setCdnCover($header);
        });
    }

    protected static function setCdnCover($header)
    {
        $cdn = env("DO_CDN");

        if (!empty($header->cover)) {
            $header->cover = $cdn . '/' . $header->cover;
        } else {
            // Preserve the current cover value
            $header->cover = $header->getOriginal('cover');
        }
    }
}
