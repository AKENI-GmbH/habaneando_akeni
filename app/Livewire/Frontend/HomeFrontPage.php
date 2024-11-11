<?php

namespace App\Livewire\Frontend;

use App\Models\Blog;
use App\Models\CourseCategory;
use Livewire\Component;

class HomeFrontPage extends Component
{
 public $posts;
 public $categories;

 public function mount()
 {
  $this->categories = CourseCategory::all()->where('featured', true);
  $this->posts = Blog::all();
 }
}
