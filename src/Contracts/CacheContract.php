<?php

namespace Veloxia\Data\Contracts;

interface CacheContract
{
    /**
     * Get stored model data from the application cache.
     *
     * @param string    $reference     Name of the cache space.
     *
     * @return array|null
     */
    public static function get(string $reference): ?array;

    /**
     * Store fetched model data in the application cache.
     *
     * @param string    $reference     Name of the cache space.
     * @param array     $data
     *
     * @return void
     */
    public static function put(string $reference, array $data): void;
}
