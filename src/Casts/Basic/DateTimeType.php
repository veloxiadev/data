<?php

namespace Veloxia\Data\Casts\Basic;

use Carbon\Carbon;
use Veloxia\Data\Casts\Type;
use Veloxia\Data\Contracts\TypeContract;

class DateTimeType extends Type implements TypeContract
{
    /**
     * @param mixed $input
     * @return \Carbon\Carbon|null
     */
    public function format($input): ?Carbon
    {
        return $input === null
            ? null
            : new Carbon($input);
    }

    public function get()
    {
        return $this->value->__toString();
    }
}
