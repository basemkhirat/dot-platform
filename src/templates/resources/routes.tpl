<?php

Route::group([
    'prefix' => ADMIN,
    'middleware' => ['web', 'auth'],
        ], function($route) {
        $route->group(['prefix' => '#module#'], function($route) {
            $route->get('/', ['uses' => '#Module|ucfirst#Controller@index', 'as' => 'admin.#module#.show']);
        });
});
