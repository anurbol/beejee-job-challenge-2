<?php

namespace Controller;

/*
Контроллер также устроен предельно просто и имеет те же характеристики что и маршрутизатор
(см. router.php).
*/

use Views\Layouts\Main;

class ErrorController {

    function page_not_found() {
        $contentProvider = function () {
            require "view/components/404.php";
        };
        $view = new Main($contentProvider);
        $view->render();
    }
}
