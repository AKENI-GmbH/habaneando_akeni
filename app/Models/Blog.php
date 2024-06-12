<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

use App\Traits\HasHeader;
use Illuminate\Support\Facades\Auth;

class Blog extends Model
{
    use HasFactory, HasSlug, HasHeader;

    protected $fillable = [
        'name',
        'slug',
        'body',
        'short_text',
        'thumbnail',
        'user_id',
        'status'
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

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function header()
    {
        return $this->morphOne(Header::class, 'headerable');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if ($blog->user_id) {
                $blog->user_id = Auth::id();
            }
        });

        static::creating(function ($item) {
            self::setCdnThumbnail($item);
        });

        static::updating(function ($item) {
            self::setCdnThumbnail($item);
        });
    }

    protected static function setCdnThumbnail($event)
    {
        $cdn = env("DO_CDN");
        $event->thumbnail = $cdn . '/' . $event->thumbnail;
    }
}
