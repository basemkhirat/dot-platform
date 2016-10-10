<?php

/*
 * WEB
 */

Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
        $route->group(array("prefix" => "media"), function($route) {
        $route->any('/get/{offset?}/{type?}/{q?}', array("as" => "admin.media.index", "uses" => "MediaController@index"));
        $route->any('/save_gallery', array("as" => "admin.media.save_gallery", "uses" => "MediaController@save_gallery"));
        $route->any('/save', array("as" => "admin.media.save", "uses" => "MediaController@save"));
        $route->any('/delete', array("as" => "admin.media.delete", "uses" => "MediaController@delete"));
        $route->any('/upload', array("as" => "admin.media.upload", "uses" => "MediaController@upload"));
        $route->any('/download', array("as" => "admin.media.download", "uses" => "MediaController@download"));
        $route->any('/link', array("as" => "admin.media.link", "uses" => "MediaController@link"));
        $route->any('/crop', array("as" => "admin.media.crop", "uses" => "MediaController@crop"));
        $route->any('/watermark', array("as" => "admin.media.watermark", "uses" => "MediaController@watermark"));
        $route->any('/galleries/create', array("as" => "admin.media.gallery_create", "uses" => "MediaController@gallery_create"));
        $route->any('/galleries/delete', array("as" => "admin.media.gallery_delete", "uses" => "MediaController@gallery_delete"));
        $route->any('/galleries/edit', array("as" => "admin.media.gallery_edit", "uses" => "MediaController@gallery_edit"));
    });
});


/*
 * API
 */
Route::group([
    "prefix" => API,
    "middleware" => ["auth:api"]
], function ($route) {
        $route->get("/media/show", "MediaApiController@show");
        $route->post("/media/create", "MediaApiController@create");
        $route->post("/media/update", "MediaApiController@update");
        $route->post("/media/destroy", "MediaApiController@destroy");
});


