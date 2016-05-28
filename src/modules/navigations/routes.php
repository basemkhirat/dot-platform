<?php

Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
    Route::resource('navigations', 'NavigationsController', ['except' => ['show']]);
    $route->group(array("prefix" => "navigations"), function($route) {
        $route->get('load/{type}/{offset?}', ['uses' => 'NavigationsController@loadItems']);
        $route->get('reorder', ['uses' => 'NavigationsController@reOrder']);
        $route->get('search/{q}', ['uses' => 'NavigationsController@search']);
    });
});
