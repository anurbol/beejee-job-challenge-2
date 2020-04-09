<?php

namespace Contracts\TasksTable;

use Model\Task;
use Utils\SimpleIterator;

class TasksIterator extends SimpleIterator {

    function next(): ?Task
    {
        return $this->default_next();
    }
}