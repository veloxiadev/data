<?php

namespace Veloxia\Data\Facades;

use Illuminate\Support\Facades\Facade;

class VD extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return static::$app['data'];
    }
}