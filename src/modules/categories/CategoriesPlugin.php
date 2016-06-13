<?php

class CategoriesPlugin extends Plugin
{

    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => trans("categories::categories.module"),
            "version" => "1.0",
        ];

    }

    function boot()
    {
        Navigation::menu("sidebar", function ($menu) {
            //$menu->item('news_options.categories', trans("categories::categories.categories"), URL::to(ADMIN . '/categories'))->icon("fa-folder")->order(1);
            $menu->item('categories', trans("categories::categories.categories"), URL::to(ADMIN . '/categories'))->icon("fa-folder")->order(1);
        });

        include __DIR__ . "/routes.php";
    }
}