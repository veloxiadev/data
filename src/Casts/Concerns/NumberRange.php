<?php

namespace Veloxia\Data\Casts\Concerns;

trait NumberRange
{
    protected $min;
    protected $max;

    public function min()
    {
        return $this->min;
    }
    public function max()
    {
        return $this->max;
    }
}
