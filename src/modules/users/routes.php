<?php

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
