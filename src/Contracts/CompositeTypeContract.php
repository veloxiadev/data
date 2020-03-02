<?php

namespace Veloxia\Data\Contracts;

use Veloxia\Data\Contracts\TypeContract;

interface CompositeTypeContract extends TypeContract
{
    /**
     * Get a list of the attributes that can be used to create this composite type. 
     *
     * @return array
     */
    public static function components(): array;
}
