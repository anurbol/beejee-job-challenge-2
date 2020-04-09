<?php


namespace Utils;


class Arr
{
    public static function find(array $array, \Closure $predicate): ?array
    {
        foreach ($array as $key => $item) {
            if ($predicate($item)) {
                return [$key, $item];
            }
        }
        return null;
    }
}