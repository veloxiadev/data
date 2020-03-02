<?php

namespace Veloxia\Data\Casts\Basic;

use Carbon\Carbon;
use Veloxia\Data\Casts\Type;
use Veloxia\Data\Contracts\TypeContract;

class DateTimeType extends Type implements TypeContract
{

    protected $value;

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

    /**
     * Flatten the Carbon object and return a string or null.
     *
     * @return void
     */
    public function get(): ?string
    {
        return $this->value instanceof Carbon
            ? $this->value->__toString()
            : null;
    }
}
