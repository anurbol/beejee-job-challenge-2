<?php

namespace Contracts\TasksTable;

use Utils\SimpleIterator;

class Column {
    public string $name;
    public string $title;

    public function __construct(string $name, string $title)
    {
        $this->name = $name;
        $this->title = $title;
    }
}