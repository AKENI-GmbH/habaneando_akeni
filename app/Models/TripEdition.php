<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class TripEdition extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'trip_id',
        'location_id',
        'code',
        'duration',
        'date_from',
        'date_to',
        'thumbnail',
        'cover',
        'reiseinfos',
        'program',
        'accommodation',
        'agb',
        'visible',
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

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function reisen()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
