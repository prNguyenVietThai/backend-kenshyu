<?php
Route::get("/", "AuthController@index");
Route::get("/login", "AuthController@showLoginPage");
Route::get("/signup", "AuthController@showSignup");
Route::post("/login", "AuthController@login");
Route::get("/logout", "AuthController@logout");
Route::post("/signup", "AuthController@signup");

Route::get("/posts", "PostController@index");
Route::get("/posts/create", "PostController@create");
Route::get("/posts/show/{id}", "PostController@show");
Route::get("/posts/edit/{id}", "PostController@edit");

Route::post("/posts/create", "PostController@store");
Route::patch("/posts/edit/{id}", "PostController@update");
Route::delete("/posts/delete/{id}", "PostController@delete");