<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'is_staff',
        'show_name',
        'origin',
        'description',
        'thumbnail',
        'facebook',
        'instagram',
        'youtube',
        'threads',
        'styles'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected static function boot()
    {
        parent::boot();


        static::creating(function ($teacher) {
            self::setCdnThumbnail($teacher);
        });

        static::updating(function ($teacher) {
            self::setCdnThumbnail($teacher);
        });
    }

    /**
     * The users that belong to the role.
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    protected static function setCdnThumbnail($event)
    {
        $cdn = env("DO_CDN");
        $event->thumbnail = $cdn . '/' . $event->thumbnail;
    }
}
