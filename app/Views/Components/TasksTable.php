<?php

namespace Views\Components;

use Contracts\PaginationItem;
use Contracts\PaginationIterator;
use Contracts\TasksTable\Column;
use Contracts\TasksTable\ColumnsIterator;
use Contracts\TasksTable\OrderDirection;
use Contracts\TasksTable\TasksIterator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Model\User;
use Utils\Arr;
use View;

class TasksTable
{
    use View;

    public TasksIterator $tasksIter;
    public ColumnsIterator $columnsIter;
    public string $orderBy = 'id';
    public OrderDirection $orderDirection;
    public PaginationIterator $paginationIterator;
    public ?User $user;

    public function __construct(LengthAwarePaginator $paginator, string $orderBy, OrderDirection $orderDirection)
    {
        $this->tasksIter = new TasksIterator($paginator->items());
        $this->paginationIterator = new PaginationIterator($this->getPaginationItems($paginator));

        $columns = [
            new Column("id", "№"),
            new Column("username", "Имя"),
            new Column("email", "Email"),
            new Column("title", "Текст"),
            new Column("done", "Статус")
        ];

        $this->columnsIter = new ColumnsIterator($columns);

        // Check if $orderBy exists and is a valid column.
        if ($orderBy && Arr::find($columns, fn($column) => $column->name === $orderBy)) {
            $this->orderBy = $orderBy;
        }

        $this->orderDirection = $orderDirection;

        $this->user = \GlobalContext::getUser();
    }

    protected function getPaginationItems(LengthAwarePaginator $paginator): array
    {
        $items = [];

        $curr = $paginator->currentPage();
        $last = $paginator->lastPage();

        array_push($items, new PaginationItem(false, $curr === 1, '&laquo;', 1));

        for ($p = 1; $p <= $last; $p++) {
            if (abs($curr - $p) > 3) {
                continue;
            }

            array_push($items, new PaginationItem($curr === $p, false, $p, $p));
        }

        array_push($items, new PaginationItem(false, $curr === $last, '&raquo;', $last));

        return $items;
    }

    public static function requireTemplate()
    {
        require 'view/components/tasks_table.php';
    }
}