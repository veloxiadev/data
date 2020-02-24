<?php

namespace Veloxia\Data\Types;

class GenericType extends Type
{
    public function pretty()
    {
        return $this->value;
    }
}
