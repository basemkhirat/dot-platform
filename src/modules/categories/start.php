<?php

Navigation::menu("sidebar", function($menu) {
    //$menu->item('news_options.categories', trans("categories::categories.categories"), URL::to(ADMIN . '/categories'))->icon("fa-folder")->order(1);
    $menu->item('categories', trans("categories::categories.categories"), URL::to(ADMIN . '/categories'))->icon("fa-folder")->order(1);
});

include __DIR__ . "/routes.php";
