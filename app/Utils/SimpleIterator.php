<?php

namespace Utils;

/**
 * PHP не поддерживает обобщенное программирование (Generics), поэтому
 * невозможно типобезопасно проходиться циклом по массивам объектов.
 * 
 * Используя итератор, вместо стандартного foreach можно
 * не жертвовать типобезопасностью.
 * 
 * Данный итератор будет работать некорректо если в массиве есть 
 * null-значения (что, впрочем, в строго-типизированных языках недопустимо).
 */
abstract class SimpleIterator
{

    private array $items;
    private int $index = 0;

    public function __construct($items)
    {
        $this->items = $items;
    }

    protected function default_next()
    {
        if (array_key_exists($this->index, $this->items)) {
            $item = $this->items[$this->index];
            $this->index++;
            return $item;
        } else {
            return null;
        }
    }

    abstract function next();
}