<?php
Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
        $route->group(array("prefix" => "tasks"), function($route) {
            $route->any('/', array("as" => "admin.tasks.show", "uses" => "TasksController@index"));
            $route->any('/create', array("as" => "admin.tasks.create", "uses" => "TasksController@create"));
            $route->any('/{id}/edit', array("as" => "admin.tasks.edit", "uses" => "TasksController@edit"));
            $route->any('/delete', array("as" => "admin.tasks.delete", "uses" => "TasksController@delete"));
            $route->any('/{status}/status', array("as" => "admin.tasks.status", "uses" => "TasksController@status"));
            $route->any('/{status}/done', array("as" => "admin.tasks.done", "uses" => "TasksController@done"));

        });
});
