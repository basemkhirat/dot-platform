<?php

class GalleriesPlugin extends Plugin
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
            "name" => "galleries",
            "version" => "1.0",
        ];

    }

    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {

            if (Gate::allows("galleries.manage")) {
                $menu->item('galleries', trans("admin::common.galleries"), URL::to(ADMIN . '/galleries'))
                    ->order(5)
                    ->icon("fa-camera");
            }
        });

        include __DIR__ . "/routes.php";

    }

}