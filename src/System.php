<?php

/**
 * System Core class
 */
class System
{
    /**
     * @var array
     */
    public $providers = [];

    /**
     * @var array
     */
    public $aliases = [

        /**
         * Laravel aliases
         */
        'Str' => Illuminate\Support\Str::class,

        /**
         * Dot aliases
         */
        'Dot' => Dot\Platform\Facades\Dot::class,
        'Module' => Dot\Platform\Facades\Module::class,
        'Navigation' => Dot\Platform\Facades\Navigation::class,
        'Action' => Dot\Platform\Facades\Action::class,
        'Widget' => Dot\Platform\Facades\Widget::class,
        'Sitemap' => Dot\Platform\Facades\Sitemap::class,
        'Schedule' => Dot\Platform\Facades\Schedule::class,
        'User' => Dot\Platform\Facades\User::class,

    ];

    /**
     * @var array
     */
    public $commands = [

        // Dot commands
        DotInstallCommand::class,
        DotUpdateCommand::class,
        DotPublishCommand::class,
        DotAutoloadCommand::class,
        DotMigrateCommand::class,
        DotUserCommand::class,

        // Modules commands
        ModuleMigrationCommand::class,
        ModuleMigrateCommand::class,
        ModuleMigrateUpCommand::class,
        ModuleMigrateDownCommand::class,
        ModuleInstallCommand::class,
        ModulePublishCommand::class,

        // Plugins commands
        PluginMakeCommand::class,
        PluginMigrationCommand::class,
        PluginMigrateCommand::class,
        PluginMigrateUpCommand::class,
        PluginMigrateDownCommand::class,
        pluginInstallCommand::class,
        PluginUninstallCommand::class,
        PluginEnableCommand::class,
        PluginDisableCommand::class,
        PluginListCommand::class,
        PluginPublishCommand::class,
        PluginUpdateCommand::class
    ];

    /**
     * @var array
     */
    public $middlewares = [
        AdminMiddleware::class
    ];

    /**
     * @var array
     */
    public $route_middlewares = [
        'auth' => AuthMiddleware::class,
        'guest' => GuestMiddleware::class,
        'role' => RoleMiddleware::class,
        'permission' => PermissionMiddleware::class
    ];

    /**
     * List of permissions
     * @var array
     */
    public $permissions = [];

    /**
     * Dot bootstrap
     * Called in system boot
     */
    public function boot()
    {

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
            error_reporting(E_ALL);
            app()->register(Barryvdh\Debugbar\ServiceProvider::class);
            DB::connection('mysql')->enableQueryLog();
        }

        /*
         * Detecting guard
         */

        if (Request::is(API . "/*")) {
            define("GUARD", "api");
        } else {
            define("GUARD", "web");
        }

        include __DIR__ . '/overrides.php';
        include __DIR__ . '/helpers.php';
        include __DIR__ . '/routes.php';

    }

}
