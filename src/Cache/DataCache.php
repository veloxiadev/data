<?php

namespace Veloxia\Data\Cache;

abstract class DataCache
{

    /**
     * The number of seconds to cache API responses, whenever this is applicable.
     *
     * @var int
     */
    protected static $cacheSeconds = 86400;

    /**
     * Create a cache tag to use when caching responses.
     *
     * @param string $graph
     *
     * @return string
     */
    protected static function makeKey(string $graph): string
    {
        return 'data.graph.' . $graph;
    }

    /**
     * Serialize a data chunk for storage.
     *
     * @param   array  $array   
     *
     * @return  string|null 
     */
    protected static function serialize($array): ?string
    {
        return serialize($array);
    }

    /**
     * Unserialize a data chunk.
     *
     * @param   string  $serialized 
     *
     * @return  array|null        
     */
    protected static function unserialize($serialized): ?array
    {
        try {
            return $serialized === null ? [] : unserialize($serialized);
        } catch (\Exception $e) {
            return [];
        }
    }
}
