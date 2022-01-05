<?php

use Illuminate\Support\Facades\Redis;

if (!function_exists('deleteCache')) {

    function deleteCache(string $key): bool
    {
        return Redis::del($key);
    }

}

if (!function_exists('setCache')) {

    function setCache(string $key, $data): bool
    {
        $setCache = Redis::set($key, $data, "EX", env("REDIS_CACHE_IN_SECOND", 5));

        if (! $setCache) {
            return false;
        }
        return true;

    }

}

if (!function_exists('getCache')) {

    function getCache(string $key)
    {
        $cachedBlog = Redis::get($key);

        if (! $cachedBlog) {
            return null;
        }

        return $cachedBlog;
    }
}
