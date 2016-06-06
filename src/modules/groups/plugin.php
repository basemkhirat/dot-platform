<?php

class GroupsProvider extends Plugin
{

    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => trans("groups::groups.module"),
            "version" => "1.0",
        ];

    }

    function boot()
    {
        Navigation::menu("sidebar", function ($menu) {
            if (User::access('groups')) {
                $menu->item('users.groups', trans("groups::groups.groups"), route("admin.groups.show"));
            }
        });

        include __DIR__ . "/routes.php";

    }
}