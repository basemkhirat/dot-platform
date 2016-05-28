<?php
Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
        $route->group(array("prefix" => "tags"), function($route) {
            $route->any('/', array("as" => "admin.tags.show", "uses" => "TagsController@index"));
            $route->any('/create', array("as" => "admin.tags.create", "uses" => "TagsController@create"));
            $route->any('/{tag_id}/edit', array("as" => "admin.tags.edit", "uses" => "TagsController@edit"));
            $route->any('/delete', array("as" => "admin.tags.delete", "uses" => "TagsController@delete"));
            $route->any('/search', array("as" => "admin.tags.search", "uses" => "TagsController@search"));
            $route->any('/migration', array("as" => "admin.tags.migration", "uses" => "TagsController@migration"));
            $route->get('google/keywords', array("as" => "admin.google.search", "uses" =>"ServicesController@keywords"));
        });
});


Route::group(array(
), function($route) {
    $route->group(array("prefix" => "tags"), function($route) {
        $route->get('migration/{offset?}', array("as" => "admin.tags.mig", "uses" => "TagsController@migrate"));
        $route->get('private_tags/{offset?}', array("as" => "admin.tags.private_tags", "uses" => "TagsController@private_tags"));
        $route->get('duplicated_tags/{offset?}', array("as" => "admin.tags.duplicated_tags", "uses" => "TagsController@duplicated_tags"));
        $route->get('script/{offset?}', array("as" => "admin.tags.script", "uses" => "TagsController@script"));
    });
});
