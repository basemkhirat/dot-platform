<?php

namespace Dot\Platform;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Class ServiceProvider
 * @package Dot\Platform
 */
class ServiceProvider extends LaravelServiceProvider
{

    /*
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Default bindings
     * @var array
     */
    protected $bindings = [
        "dot" => \Dot\Platform\Classes\Dot::class,
        "plugin" => \Dot\Platform\Classes\Plugin::class,
        "widget" => \Dot\Platform\Classes\Widget::class,
        "action" => \Dot\Platform\Classes\Action::class,
        "navigation" => \Dot\Platform\Classes\Navigation::class,
        "schedule" => \Dot\Platform\Classes\Schedule::class
    ];

    /**
     * Platform plugins
     * @var array
     */
    protected $plugins = [];


    function __construct(Application $app)
    {
        parent::__construct($app);

        foreach ($this->bindings as $abstract => $class) {
            $app->bind($abstract, function () use ($class, $app) {
                return new $class($app);
            });
        }

        $this->plugins = $app->plugin->all();
    }

    /**
     * Booting plugins
     */
    function boot()
    {
        foreach ($this->plugins as $plugin) {
            $plugin->boot();
        }
    }

    /*
     * Registering plugins
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->plugins as $plugin) {
            $plugin->register();
        }
    }
}

