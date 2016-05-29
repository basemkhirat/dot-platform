<?php

return [

    /**
     * | Admin prefix (the admin url segment)
     * |
     * | @var string
     */

    'prefix' => env("ADMIN_PREFIX", "backend"),

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
        "pages"
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
        'AdminMiddleware'
    ],

    /**
     * | The admin's route middleware.
     * |
     * | These middleware may be assigned to groups or used individually.
     * |
     * | @var array
     */

    "routed_middlewares" => [
        'auth' => 'AuthMiddleware',
        'guest' => 'GuestMiddleware'
    ],

    /**
     * | Admin commands
     * |
     * | @var array
     */

    "commands" => [
        'DotInstallCommand',
        'DotAutoloadCommand',
        'DotMigrateCommand',
        'PluginMakeCommand',
        'PluginMigrationCommand',
        'PluginMigrateCommand',
        'ModuleMigrationCommand',
        'ModuleMigrateCommand',
    ]

];
