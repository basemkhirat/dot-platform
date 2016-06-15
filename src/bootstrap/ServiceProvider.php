<?php

namespace Dot\Platform;

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
        foreach ($this->modules as $module => $module_path) {
            $this->loadModule($module, $module_path);
        }

    }

    function bindDotClasses()
    {

        $this->app->bind('dot', function () {
            return new Dot;
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

        foreach ((array)Config::get("admin.providers") as $provider) {
            $this->app->register($provider);
        }

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        foreach ((array)Config::get("admin.aliases") as $alias => $class) {
            $loader->alias($alias, $class);
        }

        $this->modules = $this->getModules();

        foreach ($this->modules as $module => $module_path) {

            Loader::add(array(
                $module_path . "/controllers",
                $module_path . "/models",
                $module_path . "/middlewares",
                $module_path . "/commands"
            ));

            if (file_exists($config = $module_path . '/config/' . $module . '.php')) {
                $this->mergeConfigFrom(
                    $config, $module
                );
            }

            /*
             * Loading modules providers
             */

            if ($module != "auth") {

                // Avoid conflict with system auth config laravel v5.2

                foreach ((array)Config::get("$module.providers") as $provider) {
                    $this->app->register($provider);
                }

                foreach ((array)Config::get("$module.aliases") as $alias => $class) {
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
        require_once(ADMIN_PATH . '/start.php');
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
        foreach ((array)Config::get("admin.middlewares") as $middleware) {
            $this->router->pushMiddlewareToGroup("web", $middleware);
            //$this->kernel->pushMiddleware($middleware);
        }

        foreach ((array)Config::get("admin.route_middlewares") as $alias => $middleware) {
            $this->router->middleware($alias, $middleware);
        }

        if (count(Config::get("admin.commands"))) {
            $this->commands(Config::get("admin.commands"));
        }

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
     * @param $module_path
     */
    protected function loadModule($module, $module_path)
    {

        foreach ((array)Config::get($module . ".middlewares") as $middleware) {
            $this->kernel->pushMiddleware($middleware);
        }

        foreach ((array)Config::get($module . ".route_middlewares") as $alias => $middleware) {
            $this->router->middleware($alias, $middleware);
        }

        if (count(Config::get($module . ".commands"))) {
            $this->commands(Config::get($module . ".commands"));
        }

        // loading module views and translations
        $this->loadViewsFrom($module_path . '/views', $module);
        $this->loadTranslationsFrom($module_path . '/lang', $module);

        // Publishing module public assets
        if (file_exists($module_path . '/public/')) {
            $this->publishes([
                $module_path . '/public/' => public_path(Module::path($module)),
            ], "$module.public");
        }

        // Publishing module config
        if (file_exists($module_path . '/config/')) {
            $this->publishes([
                $module_path . '/config/' => config_path(),
            ], "$module.config");
        }

        $class = get_plugin_class($module);

        // including module bootstrap file
        if (file_exists($bootstrap = $module_path . "/" . $class . ".php")) {

            require_once($bootstrap);

            if (class_exists($class)) {
                $plugin = new $class();
                $plugin->boot();
            }

        }


    }

    /**
     * List modules
     * @return array
     */
    protected function getModules()
    {
        return Module::components();

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