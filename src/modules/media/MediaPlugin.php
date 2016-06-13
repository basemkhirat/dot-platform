<?php

class MediaPlugin extends Plugin
{

    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => trans("media::media.module"),
            "version" => "1.0",
        ];

    }

    function boot()
    {
        include __DIR__ . "/helpers.php";
        include __DIR__ . "/routes.php";

    }

}