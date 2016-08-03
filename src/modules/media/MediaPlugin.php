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
        include __DIR__ . "/helpers.php";
        include __DIR__ . "/routes.php";

    }

}