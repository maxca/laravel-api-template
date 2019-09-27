<?php

use Hashids\Hashids;

if (!defined('CONFIG_NAME')) {
    /**
     *
     */
    define('CONFIG_NAME', 'api-generate');
}


if (!function_exists('hashIdDecode')) {
    /**
     * @param string $hash
     * @return array
     * @throws \Exception
     */
    function hashIdDecode($hash = '')
    {
        return (new Hashids(env('HASHID_SALT'), env('HASHID_LENGTH')))
            ->decode($hash);
    }
}

if (!function_exists('hashIdEncode')) {
    /**
     * @param $value
     * @return bool|string
     * @throws \Exception
     */
    function hashIdEncode($value)
    {
        return (new Hashids(env('HASHID_SALT'), env('HASHID_LENGTH')))
            ->encode($value);
    }
}