<?php

namespace Veloxia\Data\Fluent;

interface Fluent
{
    public function is($operator, $compareTo = null): Fluent;
}
