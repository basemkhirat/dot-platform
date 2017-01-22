<?php
Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ['web', 'auth'],
        ), function($route) {
        $route->group(array("prefix" => "polls"), function($route) {
            $route->any('/', array("as" => "admin.polls.show", "uses" => "PollsController@index"));
            $route->any('/create', array("as" => "admin.polls.create", "uses" => "PollsController@create"));
            $route->any('/{id}/edit', array("as" => "admin.polls.edit", "uses" => "PollsController@edit"));
            $route->any('/delete', array("as" => "admin.polls.delete", "uses" => "PollsController@delete"));
            $route->any('/{status}/status', array("as" => "admin.polls.status", "uses" => "PollsController@status"));
        });
});
