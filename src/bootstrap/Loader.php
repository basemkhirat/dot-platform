<?php

/**
 * Class Loader with caching
 */

class Loader
{

    /**
     * @var array
     */
    protected static $directories = [];

    /**
     * @param $directories
     * Fetching directories
     */
    public static function add($directories)
    {

        if (!is_array($directories)) {
            $directories = [$directories];
        }

        static::$directories = array_merge(static::$directories, $directories);
    }


    /**
     * @param bool $cached
     * Fetching directories files
     */
    public static function register($cached = true)
    {

        foreach (static::$directories as $directory) {
            foreach (glob($directory . '/*.php') as $file) {
                require_once($file);
            }
        }

        /*
        if (Storage::has("admin_classes") and $cached) {

            $files = json_decode(Storage::get('admin_classes'));
            foreach ($files as $file) {
                if(file_exists($file)) {
                    require_once($file);
                }
            }

        } else {

            $pathes = [];
            foreach (static::$directories as $directory) {
                foreach (glob($directory . '/*.php') as $file) {
                    require_once($file);
                    $pathes[] = $file;
                }
            }
            Storage::put('admin_classes', json_encode($pathes));
        }*/
    }

}
