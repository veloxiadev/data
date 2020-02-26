<?php

namespace Veloxia\Data\Casts\Financial;

use Veloxia\Data\Casts\Type;
use Veloxia\Data\Casts\Concerns\Listable;
use Veloxia\Data\Casts\Concerns\Sortable;

class Interest extends Type
{
    use Sortable, Listable;
}
