<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;
use App\Traits\HasHeader;

class Page extends Model
{
    use HasFactory, HasSlug, HasHeader;

    protected $fillable = [
        'identifier',
        'name',
        'slug',
        'image',
        'body',
        'status',
        'canDelete',
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

    /**
     * Automatically set the identifier field to the generated slug.
     */
    protected static function booted()
    {
        static::creating(function ($page) {
            $page->identifier = $page->slug;
        });
    }

    protected static function setCdnImage($page)
    {
        $cdn = env("DO_CDN");


        if (!empty($page->image)) {
            $page->image = $cdn . '/' . $page->image;
        } else {
            $page->image = $page->getOriginal('image');
        }

        dd($page);
    }

    public function header()
    {
        return $this->morphOne(Header::class, 'headerable');
    }
}
