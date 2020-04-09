<?php

namespace Views\Layouts;

use Closure;
use View;

class Main
{
    use View;

    public Closure $contentProvider;

    public function __construct(Closure $contentProvider)
    {
        $this->contentProvider = $contentProvider;
    }

    public static function requireTemplate()
    {
        require 'view/layouts/main.php';
    }
}
