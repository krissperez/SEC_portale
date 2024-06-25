<?php

namespace App\Helper;

class SessionHandler
{
    public static function controlSession()
    {
        session_start();
        if (empty($_SESSION['loggedUserId'])) {
            self::redirectToRoute('pagina_login');
        }
    }

    private static function redirectToRoute($route)
    {
        header('Location: ' . $route);
        exit();
    }
}