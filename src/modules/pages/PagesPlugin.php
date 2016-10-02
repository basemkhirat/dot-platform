<?php

class PagesPlugin extends Plugin
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
            "name" => "pages",
            "version" => "1.0",
        ];

    }

    function boot()
    {
        Navigation::menu("sidebar", function ($menu) {
            if (Gate::allows("pages.manage")) {
                $menu->item('pages', trans("admin::common.pages"), URL::to(ADMIN . '/pages'))
                    ->order(5.5)
                    ->icon("fa-file-text-o");
            }
        });

        include __DIR__ . "/routes.php";

    }
}