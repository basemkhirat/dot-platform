<?php

Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web", "auth"],
        ), function($route) {
    $route->any('/dashboard/{id?}', array("as" => "admin.dashboard.show", "uses" => "DashboardController@index"));
    $route->any('/stats', "DashboardController@stats");
});
