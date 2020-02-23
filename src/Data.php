<?php

namespace Veloxia\Data;

use Veloxia\Data\Exceptions\APIRequestException;

class Data
{
    protected static string $token;

    public function __construct(string $token)
    {
        self::$token = $token;
    }

    protected static function getToken()
    {
        if (is_null(self::$token)) {
            self::$token = config('data.token');
        }
        return self::$token;
    }

    public static function fetch(string $graph)
    {
        return self::makeApiRequest($graph, 'get');
    }

    private static function makeApiRequest($graph, $method, array $query = [])
    {
        $query[] = 'token=' . static::getToken();
        $queryString = implode('&', $query);
        $endpoint = "https://api.veloxiadata.com/${graph}/${method}?${queryString}";
        try {
            $response = file_get_contents($endpoint);
            $response = json_decode($response, true);
        } catch (\Exception $e) {
            throw new APIRequestException('Could not make API request to the endpoint.');
        }

        if ($response['success'] !== true) {
            throw new APIRequestException('Could not make API request. Message: ' . $response['message']);
        }

        return $response['data'];
    }
}
