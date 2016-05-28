<?php

use Illuminate\Database\Schema;

class SetupController extends BackendController
{

    public $data = [];

    public $root;

    function __construct()
    {
        parent::__construct();
        $this->root = dirname(dirname(dirname(__FILE__)));
    }

    function index()
    {
        $server_errors = [];
        $server_messages = [];

        // check php version

        $php_version = phpversion();

        if ($php_version < "5.5.9") {
            $server_errors[] = "Please update your php to 5.5.9, current is " . $php_version;
        } else {
            $server_messages[] = "<strong>PHP</strong> version: " . $php_version;
        }

        // check mcrypt is installed
        if (!function_exists("mcrypt_encrypt")) {
            $server_errors[] = "<strong>PHP</strong> mcrypt is not installed";
        } else {
            $server_messages[] = "<strong>PHP</strong> mcrypt is installed";
        }

        // check storage is writable

        if (!is_writable($storage_path = $this->root . "/storage")) {
            $server_errors[] = "<strong>Storage path</strong> $storage_path is not writable";
        } else {
            $server_messages[] = "<strong>Storage path</strong> $storage_path is writable";
        }


        if (!is_writable($cache_path = $this->root . "/bootstrap/cache")) {
            $server_errors[] = "<strong>Cache path</strong> $cache_path is not writable";
        } else {
            $server_messages[] = "<strong>Cache path</strong> $cache_path is writable";
        }


        $this->data["server_errors"] = $server_errors;
        $this->data["server_messages"] = $server_messages;

        return view("admin::install", $this->data);
    }


    function database()
    {

        $db = Request::get("db");

        $host = Request::get("host");
        $user = Request::get("user");
        $pass = Request::get("pass");

        $connection = NULL;
        $error = NULL;

        try {
            $connection = new mysqli($host, $user, $pass);
        } catch (Exception $error) {
            //
        }

        if (!$connection) {
            return "Invalid database server connection settings";
        }

        if (Request::has("createdb")) {
            $sql = "CREATE DATABASE " . $db;
            if ($connection->query($sql) === false) {
                return "Error creating database: " . $connection->error;
            }
        }


        // saving .env file

        return "ok";

    }



}