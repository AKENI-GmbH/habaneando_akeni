<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class Edition extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'event_id',
        'name', 
        'slug',
        'location_id',
        'date_from',
        'date_to',
        'time_from',
        'time_to',
        'thumbnail',
        'cover',
        'description',
        'short_text',
        'visible',
        'bookable',
        'onlyDoor',
        'soldout',
        'ladiesOnly'
    ];

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

    public function event(){
        return $this->belongsTo(Event::class, 'event_id');
    }
    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }
}
