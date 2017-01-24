<?php

class MediaPlugin extends Plugin
{

    public $providers = [
        Intervention\Image\ImageServiceProvider::class,
        Aws\Laravel\AwsServiceProvider::class,
    ];

    public $aliases = [
        'Image' => Intervention\Image\Facades\Image::class,
        'AWS' => Aws\Laravel\AwsFacade::class,
    ];

    /*
    public $permissions = [
        "manage_captions",
        "watermarking",
        "cropping"
    ];
    */

    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => "media",
            "version" => "1.0",
        ];

    }

    function boot()
    {

        define("UPLOADS_PATH", config("media.drivers.local.path"));

        define("AMAZON", 1);
        define("AMAZON_URL", "https://" . Config::get("media.s3.bucket") . ".s3-" . config("media.s3.region") . ".amazonaws.com/");

        include __DIR__ . "/helpers.php";
        include __DIR__ . "/routes.php";

    }

}