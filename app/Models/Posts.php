<?php

namespace App\Models;

use App\Traits\DateFormatting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory, DateFormatting;

    protected $fillable = [
        'tag_id',
        'creator_id',
        'title',
        'slug',
        'body',
        'excerpt',
        'visible_from',
        'likes',
        'unlikes',
        'status',
    ];


    /**
     * The attributes that should be formatted as dates.
     *
     * @var array
     */
    protected $dateAttributes = [
        'visible_from',
    ];

}
