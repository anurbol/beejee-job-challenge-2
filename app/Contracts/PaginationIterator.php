<?php


namespace Contracts;


use Utils\SimpleIterator;

class PaginationIterator extends SimpleIterator
{
    function next(): ?PaginationItem
    {
        return $this->default_next();
    }
}