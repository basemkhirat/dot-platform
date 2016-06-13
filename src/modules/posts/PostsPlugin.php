<?php

class PostsPlugin extends Plugin
{

    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => "Posts",
            "version" => "1.0",
        ];

    }

    function boot()
    {
        Navigation::menu("sidebar", function ($menu) {

            $menu->item('posts', trans("posts::posts.posts"), URL::to(ADMIN . '/posts'))
                ->order(0)
                ->icon("fa-newspaper-o");

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