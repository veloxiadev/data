<?php

namespace Veloxia\Data\Casts\Composites;

use Veloxia\Data\Casts\Type;
use Veloxia\Data\Casts\Concerns\NumberRange;
use Veloxia\Data\Casts\Concerns\Percent;
use Veloxia\Data\Contracts\CompositeTypeContract;

class Interest extends Type implements CompositeTypeContract
{
    use NumberRange, Percent;
    public static function components(): array
    {
        return [
            [
                'interest_from' => 'min',
                'interest_to' => 'max'
            ],
            [
                'effective_interest_from' => 'min',
                'effective_interest_to' => 'max'
            ],
        ];
    }
}
