<?php

namespace Veloxia\Data\Casts\Basic;

use Veloxia\Data\Casts\Type;
use Veloxia\Data\Contracts\TypeContract;

/**
 * Just some text.
 */
class TextType extends Type implements TypeContract
{

    protected $value;

    public function format($input): ?string
    {
        return ((string) $input) ?? null;
    }
}
