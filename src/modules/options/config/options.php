<?php

return [

    'permissions' => [
        "manage_general",
        "manage_seo",
        "manage_media",
        "manage_social",
        "manage_plugins",
    ],

    'providers' => [
        Roumen\Sitemap\SitemapServiceProvider::class
    ]
];
