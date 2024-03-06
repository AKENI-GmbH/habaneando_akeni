<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateFormatting
{

    protected $parseTo = "d-m-Y";

    /**
     * Dynamically format date attributes when accessing them.
     *
     * @param mixed $value
     * @return mixed
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if ($this->isDateAttribute($key)) {
            return $this->formatDateAttribute($value);
        }

        return $value;
    }

    /**
     * Dynamically set date attributes before saving.
     *
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if ($this->isDateAttribute($key)) {
            $value = $this->parseDateAttribute($value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Format date attribute based on the defined format.
     *
     * @param mixed $value
     * @return mixed
     */
    protected function formatDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format($this->parseTo) : null;
    }

    /**
     * Parse date attribute into the database format.
     *
     * @param mixed $value
     * @return mixed
     */
    protected function parseDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    /**
     * Check if an attribute is considered a date attribute.
     *
     * @param string $key
     * @return bool
     */
    protected function isDateAttribute($key): bool
    {
        return in_array($key, $this->dateAttributes, true);
    }
}
