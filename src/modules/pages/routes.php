<?php

/*
 * WEB
 */
Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
    $route->group(array("prefix" => "pages"), function($route) {
        $route->any('/', array("as" => "admin.pages.show", "uses" => "PagesController@index"));
        $route->any('/create', array("as" => "admin.pages.create", "uses" => "PagesController@create"));
        $route->any('/{id}/edit', array("as" => "admin.pages.edit", "uses" => "PagesController@edit"));
        $route->any('/delete', array("as" => "admin.pages.delete", "uses" => "PagesController@delete"));
        $route->any('/{status}/status', array("as" => "admin.pages.status", "uses" => "PagesController@status"));
        $route->post('newSlug', 'PagesController@new_slug');
    });
});

/*
 * API
 */
Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"]
], function ($route) {
    $route->get("/pages/show", "PagesApiController@show");
    $route->post("/pages/create", "PagesApiController@create");
    $route->post("/pages/update", "PagesApiController@update");
    $route->post("/pages/destroy", "PagesApiController@destroy");
});


