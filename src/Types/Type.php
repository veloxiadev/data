<?php

namespace Veloxia\Data\Types;

abstract class Type
{

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    protected function __toString()
    {
        try {
            return (string) $this->pretty();
        } catch (\Exception $e) {
            return (string) $this->value;
        }
    }

    abstract public function pretty();
}
