<?php

namespace Controller;

use Contracts\TasksTable\OrderDirection;
use Views\Layouts\Main;
use Views\Components\TasksTable;
use Model\Task;

class HomeController {

    function default() {

        $table = function (bool $sort = false)  {

            $orderBy = $_GET['order_by'] ?? 'id';

            $orderDirection = isset($_GET['order_direction']) && ($_GET['order_direction'] === 'desc')
                ? OrderDirection::$descending
                : OrderDirection::$ascending;

            $page = $_GET['page'] ?? 1;

            $paginator = Task::query()->orderBy($orderBy, $orderDirection::as_string)->paginate(3, ['*'], 'page', $page);

            $view = new TasksTable($paginator, $orderBy, $orderDirection);
            $view->render();
        };

        $view = new Main($table);
        $view->render();
    }
}
