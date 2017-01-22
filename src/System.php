<?php

/**
 * System Core class
 */
class System
{
    /**
     * @var array
     */
    public $providers = [
        Collective\Html\HtmlServiceProvider::class,
    ];

    /**
     * @var array
     */
    public $aliases = [

        /**
         * Laravel aliases
         */
        'Str' => Illuminate\Support\Str::class,
        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,

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

        if (Config::get("app.url") == "http://localhost") {
            Config::set("app.url", Request::root());
        }

        define("AMAZON", 1);
        define("ADMIN", Config::get("admin.prefix"));
        define("API", Config::get("admin.api"));
        define("UPLOADS", Config::get("admin.uploads_path"));
        define("UPLOADS_PATH", public_path(UPLOADS));
        define("AMAZON_URL", "https://" . Config::get("media.s3.bucket") . ".s3-" . Config::get("media.s3.region") . ".amazonaws.com/");

        if (Config::get("app.debug")) {

            error_reporting(E_ALL);

            app()->register(Barryvdh\Debugbar\ServiceProvider::class);
            DB::connection('mysql')->enableQueryLog();
        }

        /*
         * Getting the request auth guard
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