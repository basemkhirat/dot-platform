<?php

return [

    /*
     * Admin prefix (the admin url segment)
     * For security concerns, prefix should be hashed.
     * @var string
     */

    'prefix' => env("ADMIN_PREFIX", "backend"),

    /*
     * Default Page after login
     * without admin prefix
     * @var string
     */

    'default_path' => env("DEFAULT_PATH", "users"),

    /*
     * API prefix
     * As ex (api/v1)
     *
     * @var string
     */

    'api' => env("API_PREFIX", "api"),

    /*
     * All system Locales
     *
     * @var array
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

    /*
     * The place where system stores the current locale.
     * Available Settings: "session" and "url"
     * @var string
     */

    'locale_driver' => env("LOCALE_DRIVER", "session"),

    /*
     * Dot plugins
     *
     * @var array
     */

    'plugins' => [
        "admin" => Dot\Platform\System::class,
        "auth" => Dot\Auth\Auth::class,
        "users" => Dot\Users\Users::class,
        "roles" => Dot\Roles\Roles::class,
        "options" => Dot\Options\Options::class,
        "media" => Dot\Media\Media::class,
        "galleries" => Dot\Galleries\Galleries::class,
        "dashboard" => Dot\Dashboard\Dashboard::class
    ]
];
