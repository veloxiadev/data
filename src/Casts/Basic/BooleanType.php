<?php

namespace Veloxia\Data\Casts\Basic;

use Veloxia\Data\Casts\Type;
use Veloxia\Data\Contracts\TypeContract;

class BooleanType extends Type implements TypeContract
{
    public function format($input): bool
    {
        return (bool) $input === 1 || $input === true;
    }
}
