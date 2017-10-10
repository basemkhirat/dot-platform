<?php

namespace Dot\Platform;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

/**
 * Plugin Super class
 * @package Dot\Platform
 */
class Plugin extends ServiceProvider
{

    /**
     * Plugin service providers
     * @var array
     */
    protected $providers = [];

    /**
     * Plugin aliases
     * @var array
     */
    protected $aliases = [];

    /**
     * Plugin commands
     * @var array
     */
    protected $commands = [];

    /**
     * Plugin middlewares
     * @var array
     */
    protected $middlewares = [];

    /**
     * Plugin route middlewares
     * @var array
     */
    protected $route_middlewares = [];

    /**
     * Plugin permissions
     * @var array
     */
    protected $permissions = [];

    /**
     * Plugin composer files
     * @var array
     */
    private static $composers = [];

    /**
     * Plugin constructor.
     */
    public function __construct()
    {
        parent::__construct(app());
        $this->kernel = $this->app->make(Kernel::class);
        $this->router = $this->app->make(Router::class);
        $this->gate = $this->app->make(GateContract::class);
    }

    /**
     * Plugin bootstrap
     * Called in system boot
     */
    public function boot()
    {

        foreach ($this->getMiddlewares() as $middleware) {
            $this->kernel->pushMiddleware($middleware);
        }

        foreach ($this->getRouteMiddlewares() as $alias => $middleware) {
            $this->router->aliasMiddleware($alias, $middleware);
        }

        if ($this->app->runningInConsole()) {
            $this->commands($this->getCommands());
        }

        $this->loadViewsFrom($this->getPath('views'), $this->getKey());
        $this->loadTranslationsFrom($this->getPath('lang'), $this->getKey());
        $this->loadMigrationsFrom($this->getRootPath('database/migrations'));

        $this->publishes([
            $this->getRootPath('public') => public_path("plugins/" . $this->getKey()),
        ], $this->getKey() . ".public");

        $this->publishes([
            $this->getRootPath('config') => config_path(),
        ], $this->getKey() . ".config");

        $this->publishes([
            $this->getPath('views') => resource_path('views/vendor/' . $this->getKey())
        ], $this->getKey() . ".views");

        $this->loadRoutesFrom($this->getPath("routes.php"));
    }

    /**
     * Plugin registration
     * Extending core classes
     */
    public function register()
    {

        if (file_exists($config = $this->getRootPath() . '/config/' . $this->getKey() . '.php')) {
            $this->mergeConfigFrom(
                $config, $this->getKey()
            );
        }

        foreach ($this->getProviders() as $provider) {
            $this->app->register($provider);
        }

        foreach ($this->getAliases() as $alias => $class) {
            AliasLoader::getInstance()->alias($alias, $class);
        }
    }

    /**
     * Plugin install hook
     * Running plugin migrations and default options
     */
    public function install()
    {

        Artisan::call("plugin:publish", [
            "plugin" => $this->getKey(),
            "--public" => true,
            "--force" => true
        ]);

        Artisan::call("plugin:publish", [
            "plugin" => $this->getKey(),
            "--config" => true
        ]);

        Artisan::call("plugin:migrate", [
            "plugin" => $this->getKey()
        ]);
    }

    /**
     * Plugin uninstall hook
     * Rollback plugin installation
     */
    public function uninstall()
    {
        //
    }


    /**
     * Get plugin absolute path
     * @param string $path
     * @return string
     */
    public function getPath($path = NULL)
    {
        return $path ? $this->path . DIRECTORY_SEPARATOR . $path : $this->path;
    }

    /**
     * Get plugin absolute root path
     * @param string $path
     * @return string
     */
    public function getRootPath($path = NULL)
    {
        return $path ? dirname($this->path) . DIRECTORY_SEPARATOR . $path : dirname($this->path);
    }

    /**
     * Get plugin key
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get plugin key
     * @return mixed
     */
    public function getClassName()
    {
        return $this->class;
    }

    /**
     * Get plugin key
     * @return mixed
     */
    public function getClassFileName()
    {
        return $this->class_file_name;
    }

    /**
     * Get plugin providers
     * @return mixed
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Get plugin aliases
     * @return mixed
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * Get plugin middlewares
     * @return mixed
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * Get plugin route middlewares
     * @return mixed
     */
    public function getRouteMiddlewares()
    {
        return $this->route_middlewares;
    }

    /**
     * Get plugin permissions
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Get plugin commands
     * @return mixed
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * Get plugin commands
     * @return mixed
     */
    public function getName()
    {
        return $this->composer()->name ?? NULL;
    }

    /**
     * Get plugin description
     * @return mixed
     */
    public function getDescription()
    {
        return $this->composer()->description ?? NULL;
    }

    /**
     * Get plugin version
     * @return mixed
     */
    public function getVersion()
    {

        $composer_lock_file = base_path("composer.lock");

        if (file_exists($composer_lock_file)) {

            $composer_lock_content = json_decode(file_get_contents($composer_lock_file));

            $packages = $composer_lock_content->packages;

            $package = collect($packages)->where("name", $this->getName())->first();

            if($package){
                return $package->version;
            }
        }

        return "dev-master";
    }

    /**
     * Get plugin license
     * @return mixed
     */
    public function getLicense()
    {
        return $this->composer()->license ?? NULL;
    }

    /**
     * Get decoded plugin composer file
     * @return mixed
     */
    private function composer()
    {

        if (!array_key_exists($this->getKey(), self::$composers)) {
            self::$composers[$this->getKey()] = json_decode(file_get_contents(dirname($this->getPath()) . "/composer.json"));
        }

        return self::$composers[$this->getKey()];
    }

}
