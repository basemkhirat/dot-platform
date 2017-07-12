<?php

return [

    /*
     * | Admin prefix (the admin url segment)
     * | For security concerns, prefix should be hashed.
     * | @var string
     */

    'prefix' => env("ADMIN_PREFIX", "backend"),

    /*
     * | Default Page after login
     * | without admin prefix
     * | @var string
     */

    'default_path' => env("DEFAULT_PATH", "users"),

    /*
     * | API prefix
     * | As ex (api/v1)
     * |
     * | @var string
     */

    'api' => env("API_PREFIX", "api"),

    /*
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

    /*
     * | The place where system stores the current locale.
     * | Available Settings: "session" and "url"
     * | @var string
     */

    'locale_driver' => env("LOCALE_DRIVER", "session"),

    /*
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
        "navigations",
        "dashboard",
        "seo"
    ]

];
