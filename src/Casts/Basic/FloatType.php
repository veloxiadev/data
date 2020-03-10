<?php

namespace Veloxia\Data\Casts\Basic;

use Veloxia\Data\Casts\Type;
use Veloxia\Data\Contracts\TypeContract;

/**
 * A (float)ing point number. And a few decimals.
 */
class FloatType extends Type implements TypeContract
{
    protected $value;

    public function format($input): float
    {
        return round((float) $input, 2);
    }
}
