<?php

namespace App\Livewire\Frontend\Course;

use App\Models\CourseCategory;
use Livewire\Component;

class CategoryShow extends Component
{
    public $category;

    public function mount(CourseCategory $courseCategory)
    {
        $this->category = $courseCategory;
    }
}
