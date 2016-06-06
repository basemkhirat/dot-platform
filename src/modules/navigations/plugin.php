<?php

class NavigationsProvider extends Plugin
{


    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => trans("navigations::navigations.module"),
            "version" => "1.0",
        ];

    }

    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {
            // if (User::access('navigation.manage')) {
            $menu->item('options.navigations', trans("admin::common.navigations"), URL::to(ADMIN . '/navigations'))->icon("fa-tasks");
            // }
        });

        include __DIR__ . "/routes.php";


    }
}