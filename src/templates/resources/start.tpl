<?php

/*
 * Create sidebar menu item
 */

Navigation::menu("sidebar", function ($menu) {
    $menu->item('#module#', trans("#module#::#module#.module"), route("admin.#module#.show"))->order(1)->icon("fa-th-large");
});

include __DIR__ . "/routes.php";
