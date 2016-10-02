<?php
Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
        $route->group(array("prefix" => "groups"), function($route) {
            $route->any('/', array("as" => "admin.groups.show", "uses" => "GroupsController@index"));
            $route->any('/create', array("as" => "admin.groups.create", "uses" => "GroupsController@create"));
            $route->any('/{id}/edit', array("as" => "admin.groups.edit", "uses" => "GroupsController@edit"));
            $route->any('/delete', array("as" => "admin.groups.delete", "uses" => "GroupsController@delete"));
            $route->any('/{status}/status', array("as" => "admin.groups.status", "uses" => "GroupsController@status"));
            $route->any('/search', array("as" => "admin.groups.search", "uses" => "GroupsController@search"));

        });
});
