<?php

namespace Veloxia\Data;

use Veloxia\Data\Exceptions\APIException;
use Veloxia\Data\Exceptions\ItemNotFoundException;
use Veloxia\Data\Exceptions\RequestException;

class Client
{
    protected static $graph = [];
    protected static $config;

    public function __construct(array $config)
    {
        self::$config = $config;
    }

    /**
     * Get a config parameter.
     *
     * @return mixed
     */
    protected function getConfig(string $key)
    {
        return self::$config[$key];
    }

    /**
     * Magic method to capture calls and direct to the search function.
     *
     * @param string $method
     * @param mixed  $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (!method_exists($this, $method)) {
            return $this->find($method, ...$arguments);
        }
    }

    /**
     * Look for a `graph` model with a specific `slug`.
     *
     * @param string $graph the graph to search in
     * @param string $slug  slug URL
     */
    public function find(string $graph, string $slug = null): array
    {
        // First try to find a cached copy of the model.
        $cachedItem = $this->getFromCache($graph.'.'.$slug);
        if ($cachedItem) {
            return $cachedItem;
        }

        // If that fails, all models from the API and look
        // for the correct one. Also save the rest in cache
        // for later use.
        $items = $this->fetch($graph);
        if (in_array($slug, array_column($items, 'slug'))) {
            $n = array_search($slug, array_column($items, 'slug'));
            $item = $items[$n];
            $this->setInCache($graph.'.'.$slug, $item);

            return $item;
        }

        throw new ItemNotFoundException('Could not find '.$slug);
    }

    /**
     * Fetch a graph.
     */
    public function fetch(string $graph): array
    {
        // Look for data in cache.
        // If data was found in cache, return immediately.
        $data = $this->getFromCache($graph);
        if (is_array($data)) {
            return $data;
        }

        // Last option is to make an API request.
        // In this case, save the response.
        $data = $this->makeApiRequest($graph, 'get');

        $this->setInCache($graph, $data);

        // Return the results
        return $data;
    }

    /**
     * Execute an API request.
     *
     * @param string $graph  e.g. loans/cards
     * @param string $method e.g. GET/POST
     * @param array  $query  the query parameters to include
     *
     * @return array
     *
     * @throws \Veloxia\Data\Exceptions\APIRequestException
     */
    public function makeApiRequest($graph, $method, array $query = [])
    {
        $query[] = 'token='.$this->getConfig('token');
        $queryString = implode('&', $query);
        $endpoint = $this->getConfig('endpoint');
        $endpointFile = __DIR__.'/../'.$endpoint;

        // if endpoint does not exist as a file, assume it's a url
        if (!file_exists($endpointFile)) {
            $endpoint = "${endpoint}/${graph}/${method}?${queryString}";
        }

        try {
            $response = file_get_contents($endpoint);
        } catch (\Exception $e) {
            throw new RequestException('Something went wrong when requesting the API endpoint', $e);
        }

        try {
            $response = json_decode($response, true);
        } catch (\Exception $e) {
            throw new APIException('The API returned invalid JSON.', $e);
        }

        if ($response['success'] !== true) {
            throw new APIException('Could not make API request. Message: '.$response['message']);
        }

        return $response['data'];
    }

    protected function getFromCache($graph)
    {
        $output = null;
        foreach ($this->getConfig('cache_methods') as $method) {
            $data = $method::get($graph);
            $output = $data !== null ? $data : $output;
        }

        return $output;
    }

    protected function setInCache($graph, $data)
    {
        foreach ($this->getConfig('cache_methods') as $method) {
            $method::put($graph, $data);
        }
    }

    protected static function makeDummyApiRequest()
    {
        return [
            [
                'slug' => 'bank-norwegian',
                'name' => 'Testing here',
                'interest_from' => 2.9,
                'interest_to' => 29.9,
            ],
            [
                'slug' => 'testing-more',
                'name' => 'Testing here',
                'interest_from' => 2.9,
                'interest_to' => 29.9,
            ],
        ];
    }
}
