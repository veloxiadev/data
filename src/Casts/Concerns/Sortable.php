<?php

namespace Veloxia\Data\Casts\Concerns;

trait Sortable
{
    public function min()
    {
        sort($this->values);
        return array_values($this->values)[0];
    }
    public function max()
    {
        sort($this->values);
        return array_values($this->values)[count($this->values) - 1];
    }
}
