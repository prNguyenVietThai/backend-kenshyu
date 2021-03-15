<?php
    session_start();
    header('Content-Type: text/html; charset=UTF-8');

    include_once './core/Database.php';
    include_once './core/Model.php';
    include_once './core/Services.php';
    include_once './core/Controller.php';
    include_once './core/Route.php';
    include_once './helpers/csrf.php';

    include_once "./route/web.php";

    $uri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    $method_sub = $_POST['_method'];

    $http_method = strtoupper($method);
    if($method_sub){
        $method_sub = strtoupper($method_sub);
        $http_method = $method_sub;
    }

    Route::request($uri, $http_method);

