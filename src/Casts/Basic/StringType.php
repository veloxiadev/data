<?php

namespace Veloxia\Data\Casts\Basic;

use Veloxia\Data\Casts\Type;
use Veloxia\Data\Contracts\TypeContract;

class StringType extends Type implements TypeContract
{
    public function format($input): string
    {
        return (string) $input;
    }
}
