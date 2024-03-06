<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'subcategory_id',
        'position',
        'description',
    ];

    protected $allowedSort = [
        'subcategory_id',
        'position',
        'description',
    ];

    protected $cast = [
        'position' => 'integer',
    ];
    public function subcategory()
    {
        return $this->belongsTo(CourseSubcategory::class, 'subcategory_id');
    }
}
