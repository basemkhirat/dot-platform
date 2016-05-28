<?php

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
