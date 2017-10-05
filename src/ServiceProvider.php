<?php

namespace Dot\Platform;

use Dot\Platform\Facades\Plugin;
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
    public $bindings = [
        "dot" => \Dot\Platform\Classes\Dot::class,
        "plugin" => \Dot\Platform\Classes\Plugin::class,
        "widget" => \Dot\Platform\Classes\Widget::class,
        "action" => \Dot\Platform\Classes\Action::class,
        "navigation" => \Dot\Platform\Classes\Navigation::class,
        "sitemap" => \Dot\Platform\Classes\Sitemap::class,
        "schedule" => \Dot\Platform\Classes\Schedule::class,
        "menu" => \Dot\Platform\Classes\Menu::class
    ];

    /**
     * Booting plugins
     */
    function boot()
    {
        foreach (Plugin::all() as $plugin) {
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
        foreach ($this->bindings as $abstract => $class) {
            $this->app->bind($abstract, function () use ($class) {
                return new $class();
            });
        }

        foreach (Plugin::all() as $plugin) {
            $plugin->register();
        }
    }
}

