<?php

Route::group(array(
    "prefix" => ADMIN,
    "middleware" => "auth",
        ), function($route) {
        $route->group(array("prefix" => "#module#"), function($route) {
            $route->any('/', array("as" => "admin.#module#.show", "uses" => "#module|ucfirst#Controller@index"));
            $route->any('/create', array("as" => "admin.#module#.create", "uses" => "#module|ucfirst#Controller@create"));
            $route->any('/{#key#}/edit', array("as" => "admin.#module#.edit", "uses" => "#module|ucfirst#Controller@edit"));
            $route->any('/delete', array("as" => "admin.#module#.delete", "uses" => "#module|ucfirst#Controller@delete"));
            {if options.status}$route->any('/{status}/status', array("as" => "admin.#module#.status", "uses" => "#module|ucfirst#Controller@status"));{/if}

        });
});
