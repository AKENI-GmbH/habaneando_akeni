<?php


namespace App\Traits;

use App\Models\Page;



/**
 * This trait is used to relate or attach multiple files with Eloquent models.
 */
trait HasPage
{

 public $page;

 public function bootHasPage()
 {
  $page = Page::where('identifier', $this->identifier)->first();

  if (!$page) abort(404);

  $this->page = $page;
 }
}
