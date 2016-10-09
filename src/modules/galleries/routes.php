<?php

Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
), function ($route) {
    $route->group(array("prefix" => "galleries"), function ($route) {

        $route->any('/delete', array("as" => "admin.galleries.delete", "uses" => "GalleriesController@delete"));
        $route->any('/save', array("as" => "admin.galleries.save", "uses" => "GalleriesController@save"));
        $route->any('/files', array("as" => "admin.galleries.files", "uses" => "GalleriesController@files"));
        $route->any('/create', array("as" => "admin.galleries.create", "uses" => "GalleriesController@create"));
        $route->any('/{id?}', array("as" => "admin.galleries.show", "uses" => "GalleriesController@index"));

        $route->any('/content', array("as" => "admin.galleries.content", "uses" => "GalleriesController@content"));
        $route->any('/{id}/edit', array("as" => "admin.galleries.edit", "uses" => "GalleriesController@edit"));
        $route->any('/get/{offset?}', array("as" => "admin.galleries.ajax", "uses" => "GalleriesController@get"));
    });
});

/*
 * API
 */
Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"]
], function ($route) {
    $route->get("/galleries/show", "GalleriesApiController@show");
    $route->post("/galleries/create", "GalleriesApiController@create");
    $route->post("/galleries/update", "GalleriesApiController@update");
    $route->post("/galleries/destroy", "GalleriesApiController@destroy");
});



