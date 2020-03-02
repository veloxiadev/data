<?php

namespace Veloxia\Data\Casts\Basic;

use Veloxia\Data\Casts\Type;
use Veloxia\Data\Contracts\TypeContract;

/**
 * Either `true` or `false`.
 */
class BooleanType extends Type implements TypeContract
{

    protected ?bool $value;

    /**
     * If `$value == true`, this will return true. Otherwise false (not nullable). 
     *
     * @param   mixed  $input   
     *
     * @return  true|false      
     */
    public function format($input): bool
    {
        return $input == true;
    }
}
