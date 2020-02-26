<?php

namespace Veloxia\Data\Casts\Basic;

use Veloxia\Data\Casts\Type;
use Veloxia\Data\Contracts\TypeContract;

class IntegerType extends Type implements TypeContract
{
    public function format($input): int
    {
        return (int) $input;
    }
}
