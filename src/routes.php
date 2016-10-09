<?php

Route::group(["middleware" => ["web"], "namespace" => "Dot"], function ($route) {
    $route->get('locale/{lang}', ['uses' => 'LocalesController@index', 'as' => 'admin.languages']);
});

Route::group(["prefix" => ADMIN, "middleware" => ["web", "auth"], "namespace" => "Dot"], function ($route) {

    $route->any('sidebar', "SidebarController@index");

    $route->any('/', ["as" => "admin", "uses" => function () {
        $redirect_path = Config::get("admin.default_path");
        return redirect(ADMIN . "/" . trim($redirect_path));
    }]);

});

Route::group(["middleware" => ["web", "auth"]], function ($route) {
    $route->get('docs', function () {

        $guest_user = User::where("username", "guest")->first();

        if (count($guest_user) == 0) {
            return app()->abort(500, "Missing 'guest' user. please create it first.");
        }

        return view('admin::docs.default', ["user" => $guest_user]);
    });
});
