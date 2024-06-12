<?php

namespace App\Models;

use App\Traits\DateFormatting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory, DateFormatting;

    protected $fillable = [
        'tag_id',
        'creator_id',
        'title',
        'slug',
        'body',
        'excerpt',
        'visible_from',
        'likes',
        'unlikes',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();


        static::creating(function ($item) {
            self::setCdnThumbnail($item);
        });

        static::updating(function ($item) {
            self::setCdnThumbnail($item);
        });
    }


    /**
     * The attributes that should be formatted as dates.
     *
     * @var array
     */
    protected $dateAttributes = [
        'visible_from',
    ];

    protected static function setCdnThumbnail($event)
    {
        $cdn = env("DO_CDN");
        $event->thumbnail = $cdn . '/' . $event->thumbnail;
    }
}
