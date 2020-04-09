<?php


namespace Utils;


class Url
{
    public static function update(array $params)
    {
        return http_build_query(array_merge($_GET, $params));
    }
}