<?php

Route::group(["middleware" => ["web"], "namespace" => "Dot"], function ($route) {
    $route->get('locale/{lang}', ['uses' => 'LocalesController@index', 'as' => 'admin.languages']);
});

Route::group(["prefix" => ADMIN, "middleware" => ["web", "auth"], "namespace" => "Dot"], function ($route) {
    $route->any('sidebar', "SidebarController@index");
    $route->any('/',["as" => "admin", "uses" => function(){
        $redirect_path = Config::get("admin.default_path");
        return redirect(ADMIN . "/" . trim($redirect_path));
    }]);
});