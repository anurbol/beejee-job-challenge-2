<?php

use Model\Session as Session;
use Model\User as User;

/**
 * Этот класс хранит глобальный контекст (состояние).
 */
class GlobalContext
{

    private static string $controller;
    private static string $action;
    private static string $currentRouteUrl;
    private static array $pages;
    private static ?Session $session;
    private static ?User $user;

    /**
     * Так как в этом классе данные хранятся статически,
     * конструктора нет, вместо него есть инициализирующая функция ниже.
     *
     * @param $controller string Текущий контроллер, который был определен маршрутизатором.
     * @param $action string
     * @param string $currentRouteUrl
     */
    static function __init(string $controller, string $action, string $currentRouteUrl)
    {
        self::$controller = $controller;
        self::$action = $action;
        self::$currentRouteUrl = $currentRouteUrl;
    }

    static function getSession(): ?Session
    {
        $sessionKey = $_COOKIE[\Controller\AuthController::SESSION_COOKIE] ?? null;
        if ($sessionKey) {
            self::$session ??= Session::query()->where('session_key', $sessionKey)->first();
            return self::$session;
        }
        return null;
    }

    static function getUser(): ?User
    {
        $session = self::getSession();
        return self::$user ??= $session ? $session->user : null;
    }

    public static function getRouteUrl(): string
    {
        return self::$currentRouteUrl;
    }

    /**
     * @return string
     */
    public static function getAction(): string
    {
        return self::$action;
    }

}
