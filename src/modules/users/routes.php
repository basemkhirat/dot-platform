<?php

/*
 * WEB
 */
Route::group([
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"]
], function ($route) {
    $route->group(["prefix" => "users"], function ($route) {
        $route->any('/', array("as" => "admin.users.show", "uses" => "UsersController@index"));
        $route->any('/create', array("as" => "admin.users.create", "uses" => "UsersController@create"));
        $route->any('/{id}/edit', array("as" => "admin.users.edit", "uses" => "UsersController@edit"));
        $route->any('/delete', array("as" => "admin.users.delete", "uses" => "UsersController@delete"));
        $route->any('/search', array("as" => "admin.users.search", "uses" => "UsersController@search"));
    });

});

/*
 * API
 */
Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"]
], function ($route) {
    $route->get("/users/show/{id?}", "UsersApiController@show");
    $route->post("/users/create", "UsersApiController@create");
    $route->post("/users/update", "UsersApiController@update");
    $route->post("/users/destroy", "UsersApiController@destroy");
});



