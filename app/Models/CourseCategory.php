<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
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

    public function getHeaderImageAttribute()
    {
        $cdnUrl = env('DO_CDN') . '/' . $this->header->cover;

        if ($this->isImageValid($cdnUrl)) {
            return $cdnUrl;
        }

        return asset('images/header.jpeg');
    }

    private function isImageValid($url)
    {
        try {
            $response = Http::head($url);
            return $response->successful() && str_contains($response->header('Content-Type'), 'image');
        } catch (\Exception $e) {
            return false;
        }
    }
}
