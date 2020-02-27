<?php

namespace Veloxia\Data\Casts\Basic;

use Veloxia\Data\Casts\Type;
use Veloxia\Data\Contracts\TypeContract;

/**
 * A (float) number. And a few decimals.
 */
class FloatType extends Type implements TypeContract
{
    public function format($input): float
    {
        return (float) $input;
    }
}
