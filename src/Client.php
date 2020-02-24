<?php

namespace Veloxia\Data;

use Exception;
use Veloxia\Data\Exceptions\RequestException;
use Veloxia\Data\Exceptions\APIException;
use Veloxia\Data\Exceptions\ItemNotFoundException;

class Client
{
    protected static $graph = [];
    protected static $config;

    public function __construct()
    {
        self::$config = config('data');
    }

    /**
     * Get a config parameter.
     *
     * @param   string  $key 
     *
     * @return  mixed        
     */
    protected static function getConfig(string $key)
    {
        if (is_null(self::$config)) {
            self::$config = config('data');
        }
        return self::$config[$key];
    }

    /**
     * Magic method to capture static calls and direct to the search function.
     *
     * @param   string  $method    
     * @param   mixed  $arguments  
     *
     * @return  mixed               
     */
    public static function __callStatic($method, $arguments)
    {
        return self::find($method, ...$arguments);
    }

    /**
     * Magic method to capture calls and direct to the search function.
     *
     * @param   string  $method    
     * @param   mixed   $arguments  
     *
     * @return  mixed               
     */
    public function __call($method, $arguments)
    {
        return self::find($method, ...$arguments);
    }

    /**
     * Look for a `graph` model with a specific `slug`.
     *
     * @param   string  $graph  The graph to search in.
     * @param   string  $slug   Slug URL.
     *
     * @return  array           
     */
    public static function find(string $graph, string $slug): array
    {

        # First try to find a cached copy of the model.
        $cachedItem = static::getFromCache($graph . '.' . $slug);
        if ($cachedItem) {
            return $cachedItem;
        }

        # If that fails, all models from the API and look
        # for the correct one. Also save the rest in cache
        # for later use.
        $items = self::fetch($graph);
        if ($n = array_search($slug, array_column($items, 'slug'))) {
            $item = $items[$n];
            static::setInCache($graph . '.' . $slug, $item);
            return $item;
        }

        throw new ItemNotFoundException('Could not find ' . $slug);
    }

    public static function fetch(string $graph)
    {

        # Look for data in cache.
        # If data was found in cache, return immediately.
        $data = self::getFromCache($graph);
        if ($data) return $data;

        # Last option is to make an API request.
        # In this case, save the response.
        $data = self::makeApiRequest($graph, 'get');

        self::setInCache($graph, $data);

        # Return the results
        return $data;
    }

    /**
     * Execute an API request.
     *
     * @param   string $graph   e.g. loans/cards
     * @param   string $method  e.g. GET/POST
     * @param   array  $query   The query parameters to include.
     *
     * @return  array           
     * @throws  \Veloxia\Data\Exceptions\APIRequestException
     */
    private static function makeApiRequest($graph, $method, array $query = [])
    {
        $query[] = 'token=' . static::getConfig('token');
        $queryString = implode('&', $query);
        $endpoint = "${static::getConfig('endpoint')}/${graph}/${method}?${queryString}";
        try {
            $response = file_get_contents($endpoint);
            $response = json_decode($response, true);
        } catch (\Exception $e) {
            throw new RequestException('Something went wrong when requesting the API endpoint.');
        }

        if ($response['success'] !== true) {
            throw new APIException('Could not make API request. Message: ' . $response['message']);
        }

        return $response['data'];
    }

    protected static function getFromCache($graph)
    {

        $output = null;
        foreach (config('data.cache_methods') as $method) {
            $data = $method::get($graph);
            $output = $data !== null ? $data : $output;
        }
        return $output;
    }

    protected static function setInCache($graph, $data)
    {
        foreach (config('data.cache_methods') as $method) {
            $method::put($graph, $data);
        }
    }
}
