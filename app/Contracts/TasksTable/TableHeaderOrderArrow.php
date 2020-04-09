<?php


namespace Contracts\TasksTable;


class TableHeaderOrderArrow
{
    use \View;

    public string $arrowType = 'up-down';

    public function __construct(string $columnName, string $orderBy, OrderDirection $orderDirection)
    {
        if ($columnName === $orderBy) {
            $this->arrowType = $orderDirection === OrderDirection::$descending ?
                'down' : 'up';
        }
    }

    public static function requireTemplate()
    {
        require 'view/components/table_header_order_arrow.php';
    }
}