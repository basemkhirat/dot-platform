<?php

Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
    $route->group(array("prefix" => "options"), function($route) {
        $route->any('/', array("as" => "admin.options.show", "uses" => "OptionsController@index"));
        $route->any('/seo', array("as" => "admin.options.seo", "uses" => "OptionsController@seo"));
        $route->any('/modules', array("as" => "admin.options.modules", "uses" => "OptionsController@modules"));
        $route->any('/media', array("as" => "admin.options.media", "uses" => "OptionsController@media"));
        $route->any('/social', array("as" => "admin.options.social", "uses" => "OptionsController@social"));
        $route->any('/plugins', array("as" => "admin.options.plugins", "uses" => "OptionsController@plugins"));
        $route->any('/check_update', array("as" => "admin.options.check_update", "uses" => "OptionsController@check_update"));
        $route->any('/plugins/activation/{name}/{status}/{step?}', array("as" => "admin.plugins.activation", "uses" => "OptionsController@plugin"));
    });
});


Route::any('sitemap', array("as" => "admin.sitemap.update", "uses" => 'SitemapController@update'));
