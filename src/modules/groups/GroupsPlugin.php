<?php

class GroupsPlugin extends Plugin
{

    public $permissions = [
        "create",
        "edit",
        "delete"
    ];

    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => "groups",
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