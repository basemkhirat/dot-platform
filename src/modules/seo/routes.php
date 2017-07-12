<?php


Route::group(array(
    "prefix" => ADMIN,
    "middleware" => ["web"],
), function ($route) {
    $route->get('google/keywords', array("as" => "google.search", "uses" => "ServicesController@keywords"));
});
