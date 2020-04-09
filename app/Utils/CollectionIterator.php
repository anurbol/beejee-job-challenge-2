<?php


namespace Utils;


use Illuminate\Support\Collection;

abstract class CollectionIterator
{
    private Collection $items;
    private int $index = 0;

    public function __construct($items)
    {
        $this->items = $items;
    }

    protected function default_next()
    {
        if ($this->items->offsetExists($this->index)) {
            $item = $this->items[$this->index];
            $this->index++;
            return $item;
        } else {
            return null;
        }
    }

    abstract function next();
}