<?php

/**
 * Class #module|ucfirst#Plugin
 */
class #module|ucfirst#Plugin extends Plugin
{

    /**
     * Plugin directories
     * @var array
     */
    public $loader = [
        "controllers",
        "models",
        "middlewares",
        "commands"
    ];

    /**
     * Plugin providers
     * @var array
     */
    public $providers = [];

    /**
     * Plugin aliases
     * @var array
     */
    public $aliases = [];

    /**
     * Plugin commands
     * @var array
     */
    public $commands = [];

    /**
     * Plugin middlewares
     * @var array
     */
    public $middlewares = [];

    /**
     * Plugin route middlwares
     * @var array
     */
    public $route_middlewares = [];

    /**
     * Plugin permissions
     * @var array
     */
    public $permissions = [];

    /**
     * Plugin details
     * @return array
     */
     public function info()
     {
        return [
            'name' => '#module#',
            'description' => '',
            'version' => '0.1',
            'icon' => '#options.icon#',
            'author' => '',
            'url' => ''
        ];
    }

    /**
     * Plugin bootstrap
     * Called in system boot
     */
    public function boot()
    {
        parent::boot();

        Navigation::menu("sidebar", function ($menu) {
            $menu->item('#module#', trans("#module#::#module#.module"), route("admin.#module#.show"))
                ->order(1)
                ->icon("#options.icon#");
        });

        include __DIR__ . "/routes.php";

    }

    /**
    * Plugin registration
    * Extending core classes
    */
    public function register()
    {
        parent::register();
    }

    /**
     * Plugin install
     * Running plugin migrations and default options
     */
    public function install()
    {
        parent::install();
    }

    /**
     * Plugin uninstall
     * Rollback plugin installation
     */
    public function uninstall()
    {
        parent::uninstall();
    }

}


