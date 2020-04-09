<?php

namespace Contracts\TasksTable;

use Utils\SimpleIterator;

class ColumnsIterator extends SimpleIterator {
    function next(): ?Column
    {
        return $this->default_next();
    }
}
