<?php

namespace Veloxia\Data\Cache;

use Illuminate\Support\Facades\Cache;
use Veloxia\Data\Contracts\CacheContract;
use Veloxia\Data\Cache\DataCache;

/**
 * This cache method uses whatever is set as the CACHE_DRIVER in Laravel.
 */
class UseLaravelCacheDriver extends DataCache implements CacheContract
{

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
        Cache::put(
            parent::makeKey($graph),
            parent::serialize($data),
            static::$cacheSeconds
        );
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
        $data = Cache::get(parent::makeKey($graph));
        return parent::unserialize($data);
    }
}
