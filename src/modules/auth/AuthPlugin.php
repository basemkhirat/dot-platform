<?php

class AuthPlugin extends Plugin
{

    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => "auth",
            "version" => "1.0",
        ];

    }

    function boot()
    {
        include __DIR__ . "/routes.php";
    }

}