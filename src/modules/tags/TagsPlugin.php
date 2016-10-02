<?php

class TagsPlugin extends Plugin
{

    public $permissions = [
        "manage"
    ];

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

            if (Gate::allows("tags.manage")) {
                $menu->item('tags', trans("tags::tags.tags"), URL::to(ADMIN . '/tags'))->icon("fa-tags")->order(3);
            }
        });

        include __DIR__ . "/routes.php";

    }
}
