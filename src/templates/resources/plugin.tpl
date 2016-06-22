<?php

/**
 * Class #module|ucfirst#Plugin
 */
class #module|ucfirst#Plugin extends Plugin
{

    /**
     * @var array
     */
    public $providers = [];

    /**
     * @var array
     */
    public $aliases = [];

    /**
     * @var array
     */
    public $commands = [];

    /**
     * @var array
     */
    public $middlewares = [];

    /**
     * @var array
     */
    public $route_middlewares = [];

    /**
     * @var array
     */
    public $permissions = [];

    /**
     * Plugin details
     * @return array
     */
    function info(){

        return [
            'name' => '#module#',
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
            $menu->item('#module#', trans("#module#::#module#.module"), route("admin.#module#.show"))
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


