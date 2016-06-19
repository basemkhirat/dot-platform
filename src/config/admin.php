<?php

return [

    /**
     * | Admin prefix (the admin url segment)
     * |
     * | @var string
     */

    'prefix' => env("ADMIN_PREFIX", "backend"),

    /**
     * | Default URI after user authentication
     * | without admin prefix
     * | @var string
     */

    'default_path' => env("DEFAULT_PATH", "users"),

    /**
     * | All system Locales
     * |
     * | @var array
     */

    'locales' => [

        'ar' => [
            "title" => "العربية",
            "direction" => "rtl"
        ],

        'en' => [
            "title" => "English",
            "direction" => "ltr"
        ]

    ],

    /**
     * | Activated modules
     * |
     * | @var array
     */

    'modules' => [
        "users",
        "options",
        "auth",
        "roles",
        "media",
        "categories",
        "galleries",
        "tags",
        "pages",
        "posts",
        "blocks",
        "navigations"
    ],

    /**
     * | Admin Service providers
     * |
     * | @var array
     */

    'providers' => [
        Collective\Html\HtmlServiceProvider::class,
    ],

    /**
     * | Admin aliases
     * |
     * | @var array
     */

    'aliases' => [
        'Str' => Illuminate\Support\Str::class,
        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,
    ],

    /**
     * | The admin's global HTTP middleware stack.
     * |
     * | These middleware are run during every request to your admin.
     * |
     * | @var array
     */

    "middlewares" => [
        AdminMiddleware::class
    ],

    /**
     * | The admin's route middleware.
     * |
     * | These middleware may be assigned to groups or used individually.
     * |
     * | @var array
     */

    "route_middlewares" => [
        'auth' => AuthMiddleware::class,
        'guest' => GuestMiddleware::class,
        'permission' => PermissionMiddleware::class
    ],

    /**
     * | Admin commands
     * |
     * | @var array
     */

    "commands" => [

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
        PluginUpdateCommand::class,

    ]

];
