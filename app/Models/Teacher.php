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

    /**
     * Full CDN URL of the teacher's photo, or null if none was uploaded.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (empty($this->thumbnail)) {
            return null;
        }

        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        return rtrim(env('DO_CDN'), '/') . '/' . ltrim($this->thumbnail, '/');
    }

    protected static function boot()
    {
        parent::boot();


        static::creating(function ($teacher) {});

        static::updating(function ($teacher) {});
    }

    /**
     * The users that belong to the role.
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    protected static function setCdnThumbnail($event, $isUpdating = false)
    {
        $cdn = env("DO_CDN");

        if ($isUpdating) {
            if (!empty($event->thumbnail)) {
                $event->thumbnail = $cdn . '/' . $event->thumbnail;
            } else {
                $event->thumbnail = $event->getOriginal('thumbnail');
            }
        } else {
            $event->thumbnail = $cdn . '/' . $event->thumbnail;
        }
    }
}
