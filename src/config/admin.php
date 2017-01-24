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
     * | API prefix
     * | As ex (api/v1)
     * |
     * | @var string
     */

    'api' => env("API_PREFIX", "api"),

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
    ]

];
