<?php

class PostsPlugin extends Plugin
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
            "name" => "posts",
            "version" => "1.0",
        ];

    }

    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {

            if (User::access("posts.manage")) {
                $menu->item('posts', trans("posts::posts.posts"), URL::to(ADMIN . '/posts'))
                    ->order(0)
                    ->icon("fa-newspaper-o");
            }

        });

        include __DIR__ . "/routes.php";

    }

    function install()
    {
        parent::install();
    }


    function uninstall()
    {
        parent::uninstall();
    }
}