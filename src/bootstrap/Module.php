<?php

namespace Dot;

/**
 * Class Module
 */
class Module
{

    /**
     * @var array
     */
    public $pathes = [];

    public $modules = [];


    protected $config;

    function __construct()
    {
        $this->config = app("config");
    }

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