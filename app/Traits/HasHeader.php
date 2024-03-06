<?php

declare(strict_types=1);

namespace App\Traits;;

use App\Models\Header;

/**
 * This trait is used to relate or attach multiple files with Eloquent models.
 */
trait HasHeader
{

 public function header()
 {
  return $this->morphOne(Header::class, 'headerable');
 }
}
