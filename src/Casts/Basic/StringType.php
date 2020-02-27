<?php

namespace Veloxia\Data\Casts\Basic;

use Veloxia\Data\Casts\Type;
use Veloxia\Data\Contracts\TypeContract;

/**
 * A string of characters of a shorter length, for example a name or a title.
 */
class StringType extends Type implements TypeContract
{
    public function format($input): string
    {
        return (string) $input;
    }
}
