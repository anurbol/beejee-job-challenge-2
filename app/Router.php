<?php

/**
 * Данная "система маршрутизации" :-) должна работать быстро и за константное время O(1) 
 * за счёт использования ассоциативного массива ($routes).
 * 
 * Я решил не использовать сторонние библиотеки маршрутизации а также 
 * не усложнять реализованный мной вариант, так как это противоречит требованию 
 * "Этому приложению не нужна сложная архитектура, решите поставленные задачи минимально необходимым количеством кода"
 */

class Router
{
    private static array $routes = [
        'home' => Controller\HomeController::class,
        'auth' => Controller\AuthController::class,
        'tasks' => Controller\TasksController::class,
    ];

    public static function init()
    {
        $currentRouteUrl = strtok($_SERVER["REQUEST_URI"], '?');
        $chunks = explode('/', ltrim($currentRouteUrl, '/'));
        $controllerSlug = $chunks[0] ?: 'home';
        $action = $chunks[1] ?? 'default';
        $params = array_slice($chunks, 2);

        $controllerClass = self::$routes[$controllerSlug] ?? null;

        if(!$controllerClass) {
            self::page_not_found();
            return;
        }

        $controller = new $controllerClass;

        /* 
        Некоторые данные, такие как данные о текущем пользователе, 
        не удобно передавать из каждого контроллера/экшена (controller/action)
        в представление (view). К тому же мы можем столкнуться с выполнением одного кода
        в нескольких местах, а также с повторными запросами к БД, и увеличенному потреблению памяти.

        Поэтому используется глобальный контекст, который является "ленивым"
        (см. класс GlobalContext).
        */
        GlobalContext::__init($controllerClass, $action, $currentRouteUrl);

        if (!method_exists($controller, $action)) {
            self::page_not_found();
            return;
        } else {
            $controller->$action(...$params);
        }
    }

    private static function page_not_found() {
        $controller = new \Controller\ErrorController();
        $controller->page_not_found();
    }
}
