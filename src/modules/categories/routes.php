<?php

/*
 * WEB
 */
Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
    $route->group(array("prefix" => "categories"), function($route) {
        $route->any('/create', array("as" => "admin.categories.create", "uses" => "CategoriesController@create"));
        $route->any('/delete', array("as" => "admin.categories.delete", "uses" => "CategoriesController@delete"));
        $route->any('/{id?}', array("as" => "admin.categories.show", "uses" => "CategoriesController@index"));
        $route->any('/{id}/edit', array("as" => "admin.categories.edit", "uses" => "CategoriesController@edit"));
    });
});

/*
 * API
 */
Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"]
], function ($route) {
    $route->get("/categories/show", "CategoriesApiController@show");
    $route->post("/categories/create", "CategoriesApiController@create");
    $route->post("/categories/update", "CategoriesApiController@update");
    $route->post("/categories/destroy", "CategoriesApiController@destroy");
});


