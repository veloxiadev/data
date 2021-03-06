<?php

namespace Veloxia\Data\Casts\Basic;

use Veloxia\Data\Casts\Type;
use Veloxia\Data\Contracts\TypeContract;

/**
 * A whole number (int), nothing special.
 */
class IntegerType extends Type implements TypeContract
{

    protected $value;

    public function format($input): int
    {
        return (int) $input;
    }
}
