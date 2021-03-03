<?php
$router->get("/", function (){
    echo "HOME PAGE";
});
//Auth
$router->get("/login", "AuthController@showLoginPage");
$router->post("/login", "AuthController@login");
$router->get("/signup", "AuthController@signup");

//User
$router->get("/user", "UserController@index");
