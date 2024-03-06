<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;
use App\Traits\HasHeader;

class CourseCategory extends Model
{
    use HasFactory, HasSlug, HasHeader;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'featured',
    ];

    protected $casts = [
        'status' => 'boolean',
        'featured' => 'boolean',
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
     * Get the overlay opacity attribute.
     *
     * @param  string  $value
     * @return int
     */
    public function getOverlayOpacityAttribute($value)
    {
        return (int) $value;
    }

    /**
     * Set the overlay opacity attribute.
     *
     * @param  int  $value
     * @return void
     */
    public function setOverlayOpacityAttribute($value)
    {
        $this->attributes['overlayOpacity'] = (string) $value;
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

    /**
     * Return subcategories assigned to this course
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(CourseSubcategory::class, 'category_id');
    }
}
