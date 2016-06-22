<?php

class TagsPlugin extends Plugin
{


    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => "tags",
            "version" => "1.0",
        ];

    }


    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {
            $menu->item('tags', trans("tags::tags.tags"), URL::to(ADMIN . '/tags'))->icon("fa-tags")->order(3);
        });

        include __DIR__ . "/routes.php";

    }
}
