<?php

namespace Veloxia\Data;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Veloxia\Data\Skeleton\SkeletonClass
 */
class DataFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'data';
    }
}
