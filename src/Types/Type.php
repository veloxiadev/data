<?php

namespace Veloxia\Data\Types;

abstract class Type
{

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        try {
            return (string) $this->pretty();
        } catch (\Exception $e) {
            return (string) $this->value;
        }
    }

    public function numeric()
    {
        return (float) @$this->value ?: null;
    }

    abstract public function pretty();
}
