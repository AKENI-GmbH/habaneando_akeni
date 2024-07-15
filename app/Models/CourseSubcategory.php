<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class CourseSubcategory extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        '',
        'category_id',
        'description',
        'amount',
        'is_club',
        'status'
    ];

    protected $casts = [
        'is_club' => 'bool',
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
     * Return the parent category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }
    /**
     * Return the next subcategory in sequence
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nextSubcategory()
    {
        return $this->belongsTo(CourseSubcategory::class, 'next_subcategory_id');
    }

    /**
     * Return course plans assigned to this course
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plan()
    {
        return $this->hasMany(CoursePlan::class, 'subcategory_id');
    }

    /**
     * Return all courses assigned to this category
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'subcategory_id');
    }
    public function getLevelAttribute()
    {
        return $this->category->name . ' ' . $this->name;
    }

    public function getPriceAttribute()
    {
        return  $this->amount ? number_format($this->amount, 2, ',', '.') . '€' : null;
    }
}
