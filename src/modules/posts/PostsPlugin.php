<?php

/**
 * Class PostsPlugin
 */
class PostsPlugin extends Plugin
{

    /**
     * @var array
     */
    public $permissions = [
        "manage"
    ];

    /**
     * plugin info
     * @return array
     */
    function info()
    {

        return [
            "name" => "posts",
            "version" => "1.0",
        ];

    }


    /**
     *  initialize plugin
     */
    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {

            if (Gate::allows("posts.manage")) {
                $menu->item('posts', trans("posts::posts.posts"), URL::to(ADMIN . '/posts'))
                    ->order(0)
                    ->icon("fa-newspaper-o");
            }

        });

        include __DIR__ . "/routes.php";

    }

    /**
     * install plugin
     */
    function install()
    {
        parent::install();
    }


    /**
     *  uninstall plugin
     */
    function uninstall()
    {
        parent::uninstall();
    }
}
