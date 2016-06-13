<?php

class BlocksPlugin extends Plugin
{


    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => trans("blocks::blocks.module"),
            "version" => "1.0",
        ];

    }


    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {
            $menu->item('blocks', trans("blocks::blocks.blocks"), URL::to(ADMIN . '/blocks'))->icon("fa-blocks")->order(3);
        });

        include __DIR__ . "/routes.php";

    }
}
