<?php

namespace Veloxia\Data\Cache;

use Illuminate\Support\Facades\Cache;
use Veloxia\Data\Contracts\CacheContract;
use Veloxia\Data\Cache\DataCache;

/**
 * This cache method saves data in a static variable.
 */
class StaticVariableCacheDriver extends DataCache implements CacheContract
{

    /**
     * The array of cached data.
     *
     * @var array
     */
    protected static $data = [];

    /**
     * Put data in cache.
     *
     * @param   string  $graph 
     * @param   array   $data 
     *
     * @return  void  
     */
    public static function put(string $graph, array $data): void
    {
        static::$data[parent::makeKey($graph)] = parent::serialize($data);
    }

    /**
     * Get data from cache.
     *
     * @param   string      $graph  
     *
     * @return  array|null  
     */
    public static function get(string $graph): ?array
    {
        $data = static::$data[parent::makeKey($graph)] ?? null;
        return parent::unserialize($data) ?? null;
    }
}
