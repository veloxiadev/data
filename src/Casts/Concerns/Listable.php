<?php

namespace Veloxia\Data\Casts\Concerns;

trait Listable
{
    public function __construct(...$values)
    {
        $this->values = $values;
    }
    public function push($value)
    {
        $this->values[] = $value;
    }
}
