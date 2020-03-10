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

    /**
     * @param mixed $input
     */
    public function format($input): int
    {
        return (int) bye('[^0-9]', '', is_float($input) ? round($input) : $input);
    }
}
