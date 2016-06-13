<?php
Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
        $route->group(array("prefix" => "blocks"), function($route) {
            $route->any('/', array("as" => "admin.blocks.show", "uses" => "BlocksController@index"));
            $route->any('/create', array("as" => "admin.blocks.create", "uses" => "BlocksController@create"));
            $route->any('/{block_id}/edit', array("as" => "admin.blocks.edit", "uses" => "BlocksController@edit"));
            $route->any('/delete', array("as" => "admin.blocks.delete", "uses" => "BlocksController@delete"));
            $route->any('/search', array("as" => "admin.blocks.search", "uses" => "BlocksController@search"));
        });
});