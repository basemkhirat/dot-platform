<?php

Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
    $route->group(array("prefix" => "posts"), function($route) {
        $route->any('/', array("as" => "admin.posts.show", "uses" => "PostsController@index"));
        $route->any('/create', array("as" => "admin.posts.create", "uses" => "PostsController@create"));
        $route->any('/{id}/edit', array("as" => "admin.posts.edit", "uses" => "PostsController@edit"));
        $route->any('/delete', array("as" => "admin.posts.delete", "uses" => "PostsController@delete"));
        $route->any('/{status}/status', array("as" => "admin.posts.status", "uses" => "PostsController@status"));
        $route->post('newSlug', 'PostsController@new_slug');
    });
});
