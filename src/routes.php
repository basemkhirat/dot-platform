<?php

Route::group(["middleware" => ["web"]], function ($route) {
    $route->get('locale/{lang}', ['uses' => 'LocalesController@index', 'as' => 'admin.languages']);
});

Route::group(["prefix" => ADMIN, "middleware" => ["web", "auth"]], function ($route) {
    $route->any('/', ['uses' => 'UsersController@index', 'as' => 'admin']);
    $route->any('sidebar', "SidebarController@index");
});