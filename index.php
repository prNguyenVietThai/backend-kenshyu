<?php
define('PATH_ROOT', __DIR__);
include './core/mvc/Database.php';
include './core/mvc/Model.php';
include './core/mvc/Controller.php';

spl_autoload_register(function($className) {
    include_once './models/' . $className . '.php';
    include_once './views/' . $className . '.php';
    include_once './controllers/' . $className . '.php';
});

include_once './core/http/Route.php';

$router = new Route();
$request_url = !empty($_GET['url']) ? '/' . $_GET['url'] : '/';
$method_url = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
include "./route/web.php";

$router->map($request_url, $method_url);



