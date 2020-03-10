<?php

namespace Veloxia\Data\Fluent;

use Veloxia\Data\Query;

trait MakeFluent
{
    /**
     * @var \Veloxia\Data\Fluent\Fluent
     */
    protected $instance;

    /**
     * Query this graph model fluently.
     *
     * @param string $reference
     *
     * @return \Veloxia\Data\Fluent\Fluent
     */
    public function if($reference): Fluent
    {
        $this->instance = new Query($reference, $this);

        return $this->instance;
    }
}
