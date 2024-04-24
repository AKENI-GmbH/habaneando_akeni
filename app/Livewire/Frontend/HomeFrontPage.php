<?php

namespace App\Livewire\Frontend;

use App\Models\Blog;
use Livewire\Component;

class HomeFrontPage extends Component
{
 public $posts;

 public function mount()
 {
  $this->posts = Blog::all();
 }
}
