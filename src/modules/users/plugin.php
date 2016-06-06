<?php

class UsersProvider extends Plugin
{


    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => trans("users::users.module"),
            "version" => "1.0",
        ];

    }


    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {

            if (User::access('users')) {
                $menu->item('users', trans("admin::common.users"), "javascript:void(0)")
                    ->order(16)
                    ->icon("fa-users");

                $menu->item('users.all', trans("admin::common.users"), route("admin.users.show"));
            }
        });

        Widget::sidebar("dashboard.middle", function ($widget) {

            $users = User::where("status", 1)
                ->select("users.*", "roles.*", "users.id as id", "roles.name as role_name")
                ->leftJoin("media", "media.media_id", "=", "users.photo_id")
                ->join("roles", "roles.id", "=", "users.role_id")
                ->orderBy("users.id", "DESC")
                ->take(7)->get();

            return view("users::widgets.users", ["users" => $users]);

        });

        include __DIR__ . "/routes.php";

    }
}
