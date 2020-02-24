<?php

namespace Veloxia\Data\Types;

class Undefined extends Type
{


    public function __construct($value = null)
    {
        //
    }

    public function set($value)
    {
        // Not possible to set an Undefined property.
    }

    public function pretty()
    {
        return '–';
    }
}
