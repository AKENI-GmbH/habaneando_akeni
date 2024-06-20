<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;
use App\Traits\HasHeader;

class Event extends Model
{
    use HasFactory, HasSlug, HasHeader;

    protected $fillable = [
        'name',
        'slug',
        'date_from',
        'date_to',
        'time_from',
        'time_to',
        'description',
        'conditions',
        'program',
        'accomodation',
        'extras',
        'short_text',
        'visible',
        'bookable',
        'onlyDoor',
        'soldOut',
        'ladiesOnly',
        'status',
        'thumbnail',
        'location_id',
        'event_type',
        'ticket_type_id',
    ];

    /**
     * The attributes that should be formatted as dates.
     *
     * @var array
     */
    protected $dateAttributes = [
        'date_from',
        'date_to',
    ];

    protected $casts = [
        'extras' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            self::setCdnThumbnail($event);
        });

        static::updating(function ($event) {
            self::setCdnThumbnail($event, true);
        });

        static::created(function ($event) {
            event(new \App\Events\EventCreated($event));
        });

        static::updated(function ($event) {
            event(new \App\Events\EventUpdated($event));
        });

        static::deleted(function ($event) {
            event(new \App\Events\EventDeleted($event));
        });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function editions()
    {
        return $this->hasMany(Edition::class, 'event_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function condition()
    {
        return $this->morphOne(Header::class, 'conditionable');
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'event_teacher');
    }

    public function header()
    {
        return $this->morphOne(Header::class, 'headerable');
    }

    protected static function setCdnThumbnail($event, $isUpdating = false)
    {
        $cdn = env("DO_CDN");

        if ($isUpdating) {
            if (!empty($event->thumbnail)) {
                $event->thumbnail = $cdn . '/' . $event->thumbnail;
            } else {
                $event->thumbnail = $event->thumbnail;
            }
        } else {
            $event->thumbnail = $cdn . '/' . $event->thumbnail;
        }
    }
}
