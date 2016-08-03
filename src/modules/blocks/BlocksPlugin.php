<?php

class BlocksPlugin extends Plugin
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
            "name" => "blocks",
            "version" => "1.0",
        ];

    }


    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {
            if (User::access("blocks.manage")) {
                $menu->item('blocks', trans("blocks::blocks.blocks"), URL::to(ADMIN . '/blocks'))->icon("fa fa-th-large")->order(4);
            }
        });

        include __DIR__ . "/routes.php";

    }
}
