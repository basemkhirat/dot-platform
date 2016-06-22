<?php

namespace Dot\Platform;

use Dot;
use System;
use Plugin;
use Illuminate\Support\Facades\Schema;
use \Loader;
use \DB;
use Mockery\CountValidator\Exception;
use \Module;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * Class AdminServiceProvider
 */
class CmsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Modules list.
     *
     * @var array
     */
    protected $modules = [];

    /**
     * Options list.
     *
     * @var array
     */
    protected $options = [];


    /**
     * AdminServiceProvider constructor.
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct($app)
    {

        if (Config::get("app.key") == "") {
            return false;
        }

        $this->app = $app;
        $this->kernel = $this->app->make('Illuminate\Contracts\Http\Kernel');

    }


    function boot(\Illuminate\Routing\Router $router)
    {

        if (Config::get("app.key") == "") {
            return false;
        }

        // Extend Auth class
        Config::set("auth.providers.users.model", \User::class);

        $this->router = $router;

        // Initializing admin
        $this->loadAdmin();

        // Initializing modules
        foreach ($this->modules as $module) {
            $this->loadModule($module);
        }

    }

    function bindDotClasses()
    {

        $this->app->bind('dot', function () {
            return new DotPlatform;
        });

        $this->app->bind('module', function () {
            return new DotModule;
        });

        $this->app->bind('widget', function () {
            return new DotWidget;
        });

        $this->app->bind('action', function () {
            return new DotAction;
        });

        $this->app->bind('navigation', function () {
            return new DotNavigation;
        });

        $this->app->bind('sitemap', function () {
            return new DotSitemap;
        });

        $this->app->bind('schedule', function () {
            return new DotSchedule;
        });

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        if (Config::get("app.key") == "") {
            return false;
        }

        define("ROOT_PATH", dirname(public_path()));
        define("ADMIN_PATH", dirname(dirname(__FILE__)));
        define("MODULES_PATH", ADMIN_PATH . "/modules");
        define("PLUGINS_PATH", ROOT_PATH . "/plugins");

        if (Schema::hasTable("options")) {
            foreach (DB::table("options")->get() as $option) {
                Config::set($option->name, $option->value);
            }
        }

        // Binging dot classes
        $this->bindDotClasses();

        $this->system = $this->getSystem();

        // loading admin configuration file
        $this->mergeConfigFrom(
            ADMIN_PATH . '/config/admin.php', "admin"
        );

        Loader::add(array(
            ADMIN_PATH . "/controllers",
            ADMIN_PATH . "/models",
            ADMIN_PATH . "/middlewares",
            ADMIN_PATH . "/commands"
        ));

        /*
         * Loading admin providers
         */

        foreach ($this->system->providers as $provider) {
            $this->app->register($provider);
        }

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        foreach ($this->system->aliases as $alias => $class) {
            $loader->alias($alias, $class);
        }

        $this->modules = $this->getComponents();

        foreach ($this->modules as $module) {

            Loader::add(array(
                $module->root . "/controllers",
                $module->root . "/models",
                $module->root . "/middlewares",
                $module->root . "/commands"
            ));

            if (file_exists($config = $module->root . '/config/' . $module->path . '.php')) {
                $this->mergeConfigFrom(
                    $config, $module->path
                );
            }

            /*
             * Loading modules providers
             */

            if ($module->path != "auth") {

                // Avoid conflict with system auth config laravel v5.2

                foreach ($module->providers as $provider) {
                    $this->app->register($provider);
                }

                foreach ($module->aliases as $alias => $class) {
                    $loader->alias($alias, $class);
                }
            }

        }

        if (Config::get("app.env") == "production") {
            $cached = true;
        } else {
            $cached = false;
        }

        Loader::register($cached);

        // loading admin bootstrap file
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }


    /**
     *  Loading Admin
     */
    protected function loadAdmin()
    {
        foreach ($this->system->middlewares as $middleware) {
            $this->router->pushMiddlewareToGroup("web", $middleware);
        }

        foreach ($this->system->route_middlewares as $alias => $middleware) {
            $this->router->middleware($alias, $middleware);
        }

        $this->commands($this->system->commands);

        // loading admin views and translations
        $this->loadViewsFrom(ADMIN_PATH . '/views', 'admin');
        $this->loadTranslationsFrom(ADMIN_PATH . '/lang', 'admin');

        // publishing admin public files
        $this->publishes([
            ADMIN_PATH . '/public/' => public_path('admin'),
        ], "admin.public");

        // Publishing admin config files
        $this->publishes([
            ADMIN_PATH . '/config/' => config_path()
        ], "admin.config");

    }

    /**
     * Load specific module
     * @param $module
     */
    protected function loadModule($module)
    {

        foreach ($module->middlewares as $middleware) {
            $this->kernel->pushMiddleware($middleware);
        }

        foreach ($module->route_middlewares as $alias => $middleware) {
            $this->router->middleware($alias, $middleware);
        }

        $commands = $module->commands;
        if (count($commands)) {
            $this->commands($commands);
        }

        // loading module views and translations
        $this->loadViewsFrom($module->root . '/views', $module->path);
        $this->loadTranslationsFrom($module->root . '/lang', $module->path);

        // Publishing module public assets
        if (file_exists($module->root . '/public/')) {
            $this->publishes([
                $module->root . '/public/' => public_path(Module::path($module->path)),
            ], "$module->path.public");
        }

        // Publishing module config
        if (file_exists($module->root . '/config/')) {
            $this->publishes([
                $module->root . '/config/' => config_path(),
            ], "$module->path.config");
        }

        // Booting
        $module->boot();

    }


    function getSystem()
    {

        require_once(ADMIN_PATH . '/System.php');

        $system = new System();
        $system->boot();

        return $system;

    }

    /**
     * List modules
     * @return array
     */
    protected function getComponents()
    {
        return array_merge(Module::all(), Plugin::installed());
    }

}

/**
 * @param $module
 * @return string
 * Helper function to get module path
 */
function get_module_path($module)
{

    $module_path = NULL;

    if (file_exists(PLUGINS_PATH . "/" . $module)) {
        $module_path = PLUGINS_PATH . "/" . $module;
    } elseif (file_exists(MODULES_PATH . "/" . $module)) {
        $module_path = MODULES_PATH . "/" . $module;
    }

    return $module_path;
}