<?php

// CMS Version
define("DOT_VERSION", "0.0.37");

if (Config::get("app.url") == "http://localhost") {
    Config::set("app.url", Request::root());
}

define("AMAZON", 1);
define("ADMIN", Config::get("admin.prefix"));
define("UPLOADS", "uploads");
define("UPLOADS_PATH", public_path(UPLOADS));
define("AMAZON_URL", "https://" . Config::get("media.s3.bucket") . ".s3-" . Config::get("media.s3.region") . ".amazonaws.com/");

if (Config::get("app.debug")) {

    error_reporting(E_ALL);

    app()->register(Barryvdh\Debugbar\ServiceProvider::class);
    DB::connection('mysql')->enableQueryLog();
}

include __DIR__ . '/overrides.php';
include __DIR__ . '/helpers.php';
include __DIR__ . '/routes.php';