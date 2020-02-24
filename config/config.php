<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API TOKEN
    |--------------------------------------------------------------------------
    |
    | The Veloxiadata token, which is required to access models.
    |
    */

    'token'             => env('VD_API_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | API ENDPOINT URL
    |--------------------------------------------------------------------------
    |
    | The endpoint URL to use.
    |
    */

    'endpoint'          => env('VD_API_ENDPOINT'),

    /*
    |--------------------------------------------------------------------------
    | CACHE METHODS
    |--------------------------------------------------------------------------
    |
    | Add the cache method that should be used. More than one driver can be
    | used, providing redundancy.
    |
    */

    'cache_methods'     => [
        Veloxia\Data\Cache\StaticVariableCacheDriver::class,
        Veloxia\Data\Cache\UseLaravelCacheDriver::class
    ],

];
