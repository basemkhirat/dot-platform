<?php

namespace Dot\Platform;


/**
 * Class DotModule
 * @package Dot\Platform
 */
class DotModule
{

    /**
     * @var array
     */
    public $pathes = [];

    /**
     * @var array
     */
    public $modules = [];


    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $config;

    /**
     * DotModule constructor.
     */
    function __construct()
    {
        $this->config = app("config");
    }

    /**
     * @return array
     */
    public function all(){

        foreach ((array)$this->config->get("admin.modules") as $module) {
            if ($module_path = get_module_path($module)) {
                $this->modules[$module] = $module_path;
            }
        }

        foreach (glob(PLUGINS_PATH . '/*/start.php') as $file) {
            $module_path = dirname($file);
            $this->modules[basename($module_path)] = $module_path;
        }

        return $this->modules;
    }

    /**
     * @param $module
     * @param $path
     */
    public function set($module, $path)
    {
        self::$pathes[$module] = $path;
    }

    /**
     * @param $module
     * @return mixed
     */
    public function path($module)
    {
        return $this->modules[$module];
    }

}