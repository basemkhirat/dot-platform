<?php

Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
    Route::resource('navigations', 'NavsController', ['except' => ['show']]);
    $route->group(array("prefix" => "navigations"), function($route) {
        $route->get('load/{type}/{offset?}', ['uses' => 'NavsController@loadItems']);
        $route->get('reorder', ['uses' => 'NavsController@reOrder']);
        $route->get('search/{q}', ['uses' => 'NavsController@search']);
    });
});
