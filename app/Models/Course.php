<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use App\Traits\DateFormatting;
use Spatie\Sluggable\HasSlug;
use Carbon\Carbon;

class Course extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'google_event_id',
        'course_id',
        'name',
        'slug',
        'location_id',
        'schedule_day',
        'schedule_time_from',
        'schedule_time_to',
        'start_date',
        'end_date',
        'subcategory_id',
        'teacher1_id',
        'teacher2_id',
        'description',
        'showMessage',
        'messageTitle',
        'messageDescription',
        'status',
        'is_club',
        'bookable',
        'endless',
        'allowClub',
        'allowsinglePayment',
        'soldout',
        'amount'
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'course_id',
        'is_club',
        'start_date',
        'end_date',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            $course->course_id = $course->generateCourseId();
        });

        static::updating(function ($course) {
            $course->course_id = $course->generateCourseId();
        });
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }

    /**
     * Generate a unique course ID.
     *
     * @return string
     */
    public function generateCourseId()
    {
        $subcategory = $this->subcategory()->with('category')->first();

        if (!$subcategory || !$subcategory->category) {
            return '';
        }

        $categoryInitials = substr($subcategory->category->name, 0, 2);
        $subcategoryInitials = substr($subcategory->name, 0, 2);
        $date = Carbon::now()->format('ny');
        $randomNumber = rand(1, 999);

        return strtoupper($categoryInitials . '-' . $subcategoryInitials  . $date . $randomNumber);
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


    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function getDayAbbreviationAttribute(): string
    {
        $dayMap = [
            'Montag' => 'Mo',
            'Dienstag' => 'Di',
            'Mittwoch' => 'Mi',
            'Donnerstag' => 'Do',
            'Freitag' => 'Fr',
            'Samstag' => 'Sa',
            'Sonntag' => 'So',
        ];

        return $dayMap[$this->schedule_day] ?? $this->schedule_day;
    }

    public function subcategory()
    {
        return $this->belongsTo(CourseSubcategory::class, 'subcategory_id');
    }

    public function primaryTeacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher1_id');
    }

    public function secondaryTeacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher2_id');
    }


    public function subscriptions()
    {
        return $this->hasMany(CourseSubscription::class, 'course_id');
    }

    public function header()
    {
        return $this->morphOne(Header::class, 'headerable');
    }
}
