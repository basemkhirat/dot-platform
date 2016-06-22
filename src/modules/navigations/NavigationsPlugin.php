<?php

/**
 * Class NavigationsProvider
 */
class NavigationsPlugin extends Plugin
{

    /**
     * Plugin details
     * @return array
     */
    function info(){

        return [
            'name' => "navigations",
            'description' => '',
            'version' => '0.1',
            'icon' => 'fa-puzzle-piece',
            'author' => '',
            'url' => ''
        ];

    }

    /**
     * Plugin bootstrap
     * Called in system boot
     */
    function boot(){

        Navigation::menu("sidebar", function ($menu) {
            $menu->item('navigations', trans("navigations::navigations.module"), route("admin.navigations.show"))
            ->order(1)
            ->icon("fa-th-large");
        });

        include __DIR__ . "/routes.php";

    }

    /**
     * Plugin install
     * Running plugin migrations and default options
     */
    function install(){
        parent::install();
    }

    /**
     * Plugin uninstall
     * Rollback plugin installation
     */
    function uninstall(){
        parent::uninstall();
    }

}


