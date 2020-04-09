<?php


namespace Contracts\TasksTable;

abstract class OrderDirection
{
    public static Ascending $ascending;
    public static Descending $descending;

    abstract function get_opposite_str(): string;
}

OrderDirection::$ascending = new Ascending();
OrderDirection::$descending = new Descending();

class Ascending extends OrderDirection
{
    public const as_string = 'asc';

    function get_opposite_str(): string
    {
        return Descending::as_string;
    }
}

class Descending extends OrderDirection
{
    public const as_string = 'desc';

    function get_opposite_str(): string
    {
        return Ascending::as_string;
    }
}