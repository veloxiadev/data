<?php

namespace Veloxia\Data\Casts\Concerns;

trait Percent
{
    public function format(float $value)
    {
        return round($value, 2);
    }
}
