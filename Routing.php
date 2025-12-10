<?php
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';
class Routing {

    public static $routes = [
        'login' => 'SecurityController@login',
        'logout' => 'SecurityController@logout',
        'dashboard' => 'DashboardController@dashboard',
        'register' => 'SecurityController@register',
        'search-cards' => 'DashboardController@search'
    ];

        public static function run($path) {
        switch($path) {
            case 'login':
                $controller = new SecurityController();
                $controller->login();
                break;
            case 'logout':
                $controller = new SecurityController();
                $controller->logout();
                break;
            case 'dashboard':
                $controller = new DashboardController();
                $controller->dashboard();
                break;
            case 'register':
                $controller = new SecurityController();
                $controller->register();
                break;
            case 'search-cards':
                $controller = new DashboardController();
                $controller->search();
                break;
            default:
                include 'public/views/404.html';
                break;
        }
    }
/*
    public static function run($path) {
        if (array_key_exists($path, self::$routes)) {
            // Pobierz wpis z tablicy routes
            $route = self::$routes[$path]; // "SecurityController@login"

            // Rozdziel na nazwę kontrolera i metodę
            list($controllerName, $action) = explode('@', $route);

            // Utwórz obiekt kontrolera
            $controller = new $controllerName();

            // Wywołaj metodę kontrolera
            $controller->$action();
        } else {
            include 'public/views/404.html';
        }
    }

*/
}
