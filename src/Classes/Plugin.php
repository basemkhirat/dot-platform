<?php

namespace Dot\Platform\Classes;

use Illuminate\Foundation\Application;
use ReflectionClass;

/**
 * Class Plugin
 * @package Dot\Platform\Classes
 */
class Plugin
{

    /**
     * Loaded plugins
     * @var array
     */
    protected $plugins = [];

    /**
     * Get all plugins
     * @return array
     */
    public function all()
    {

        if (count($this->plugins)) {
            return $this->plugins;
        }

        foreach (config("admin.plugins") as $key => $class) {

            $plugin = $this->get($key, $class);

            if ($plugin) {
                $this->plugins[$key] = $plugin;
            }

        }

        return $this->plugins;
    }


    /**
     * get plugin details
     * @param $key
     * @return mixed
     */
    public function get($key)
    {

        $class = config("admin.plugins.".$key);

        if (class_exists($class)) {

            $reflection = new ReflectionClass($class);

            $plugin = new $class();


            $plugin->key = $key;
            $plugin->path = dirname($reflection->getFileName());
            $plugin->class = $class;
            $plugin->class_file_name = basename($reflection->getFileName());

            return $plugin;
        }

    }

}
