<?php


namespace Contracts;


class PaginationItem
{
    public bool $active;
    public bool $disabled;
    public string $label;
    public int $targetPage;

    public function __construct(bool $active, bool $disabled, string $label, int $targetPage)
    {
        $this->active = $active;
        $this->disabled = $disabled;
        $this->label = $label;
        $this->targetPage = $targetPage;
    }
}

