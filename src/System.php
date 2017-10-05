<?php

namespace Dot\Platform;

use Dot\Platform\Classes\DotUrlGenerator;
use Dot\Platform\Facades\Dot;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Artisan;

/**
 * Class System
 * System Core class
 * @package Dot\Platform
 */
class System extends Plugin
{

    /**
     * System providers
     * @var array
     */
    protected $aliases = [

        /**
         * Laravel aliases
         */
        'Str' => \Illuminate\Support\Str::class,

        /**
         * Dot aliases
         */
        'Dot' => \Dot\Platform\Facades\Dot::class,
        'Plugin' => \Dot\Platform\Facades\Plugin::class,
        'Navigation' => \Dot\Platform\Facades\Navigation::class,
        'Menu' => \Dot\Platform\Facades\Menu::class,
        'Action' => \Dot\Platform\Facades\Action::class,
        'Widget' => \Dot\Platform\Facades\Widget::class,
        'Sitemap' => \Dot\Platform\Facades\Sitemap::class,
        'Schedule' => \Dot\Platform\Facades\Schedule::class,
    ];

    /**
     * System commands
     * @var array
     */
    protected $commands = [

        // Dot commands
        \Dot\Platform\Commands\DotInstallCommand::class,
        \Dot\Platform\Commands\DotUpdateCommand::class,
        \Dot\Platform\Commands\DotPublishCommand::class,
        \Dot\Platform\Commands\DotMigrateCommand::class,
        \Dot\Platform\Commands\DotUserCommand::class,

        // Plugins commands
        \Dot\Platform\Commands\PluginListCommand::class,
        \Dot\Platform\Commands\PluginMigrationCommand::class,
        \Dot\Platform\Commands\PluginMigrateCommand::class,
        \Dot\Platform\Commands\PluginInstallCommand::class,
        \Dot\Platform\Commands\PluginUninstallCommand::class,
        \Dot\Platform\Commands\PluginUpdateCommand::class,
        \Dot\Platform\Commands\PluginEnableCommand::class,
        \Dot\Platform\Commands\PluginDisableCommand::class,
        \Dot\Platform\Commands\PluginPublishCommand::class

    ];

    /**
     * System middlewares
     * @var array
     */
    protected $middlewares = [
        \Dot\Platform\Middlewares\AdminMiddleware::class
    ];

    /**
     * system bootstrap
     * Called in system boot
     */
    public function boot()
    {

        $this->publishes([
            $this->getPath('views/errors') => resource_path('views/errors')
        ], $this->getKey() . ".errors");

        if (config("admin.locale_driver") == "url") {

            $request = $this->app->make('request');

            /* Redirect backend urls have no locale code */

            if ($request->is(config('admin.prefix') . "/*")) {

                $url = implode('/', array_prepend($request->segments(), $this->app->getLocale()));

                if ($request->getQueryString()) {
                    $url .= "?" . $request->getQueryString();
                }

                redirect($url)->send();
            }

            Config::set("admin.prefix", $request->segment(1) . "/" . config("admin.prefix"));

            app()->bind('url', function () {
                return new DotUrlGenerator(
                    app()->make('router')->getRoutes(),
                    app()->make('request')
                );
            });


        }

        define("DOT_VERSION", Dot::version());
        define("ADMIN", config("admin.prefix"));
        define("API", config("admin.api"));

        /*
         * Auto detecting website domain.
         */

        if (Config::get("app.url") == "http://localhost") {
            Config::set("app.url", Request::root());
        }

        /*
         * Debugging
         */

        if (Config::get("app.debug")) {
            app()->register(\Barryvdh\Debugbar\ServiceProvider::class);
            DB::connection('mysql')->enableQueryLog();
        }

        /*
         * Detecting guard
         */

        if (Request::is(ADMIN . "/*")) {
            define("GUARD", "backend");
        } elseif (Request::is(API . "/*")) {
            define("GUARD", "api");
        } else {
            define("GUARD", "frontend");
        }

        require_once $this->getPath('overrides.php');
        require_once $this->getPath('helpers.php');

        parent::boot();
    }

    /**
     *  Registering services
     */
    function register()
    {

        @date_default_timezone_set(config("app.timezone"));

        parent::register();
    }


    /**
     * Install hook
     */
    function install(){
        parent::install();



    }

}
