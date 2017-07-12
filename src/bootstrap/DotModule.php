<?php

namespace Dot\Platform;

use Dot;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

/**
 * Class DotModule
 * @package Dot\Platform
 */
class DotModule
{

    /**
     * @var array
     */
    public $paths = [];

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
    public function components()
    {

        foreach ((array)$this->config->get("admin.modules") as $module) {
            if ($module_path = get_module_path($module)) {
                $this->modules[$module] = $module_path;
                $this->paths[$module] = "modules/" . $module;
            }
        }

        if ($this->config->has("plugins")) {
            $plugins = json_decode($this->config->get("plugins"));
            foreach ($plugins as $plugin) {
                $this->modules[$plugin] = PLUGINS_PATH . "/" . $plugin;
                $this->paths[$plugin] = "plugins/" . $plugin;
            }
        }

        return $this->modules;
    }

    /**
     * @param $module
     * @param $path
     */
    public function set($module, $path)
    {
        $this->paths[$module] = $path;
    }

    /**
     * @param $module
     * @return mixed
     */
    public function path($module)
    {
        return isset($this->paths[$module]) ? $this->paths[$module] : "";
    }


    /**
     * Get all installed modules
     * @return array
     */
    public static function installed()
    {
        $modules = [];

        $installed_modules = self::installedPaths();

        foreach (glob(MODULES_PATH . '/*/*Plugin.php') as $file) {

            $module_path = dirname($file);

            $folder_name = basename($module_path);

            if (in_array($folder_name, $installed_modules)) {

                $module = self::get($folder_name);

                if ($module and $module->path != "") {
                    $modules[$module->path] = $module;
                }

            }
        }

        return $modules;

    }

    /**
     * Get all system plugins
     * @return array
     */
    public static function all()
    {
        $plugins = [];

        foreach (glob(MODULES_PATH . '/*/*Plugin.php') as $file) {

            $module_path = dirname($file);

            $folder_name = basename($module_path);

            $plugin = self::get($folder_name);

            if ($plugin and $plugin->path != "") {
                $plugins[] = $plugin;
            }
        }

        return $plugins;

    }

    /**
     * Get plugin by folder name
     * @param string $plugin_folder
     * @return bool|Plugin
     */
    public static function get($plugin_folder = "")
    {

        if ($plugin_folder == "") {
            return false;
        }

        $path = MODULES_PATH . "/" . $plugin_folder;

        $class = Dot::getPluginClass($path);

        if (!class_exists($class)) {
            include($path . "/" . $class . ".php");
        }

        if (class_exists($class)) {

            $object = new $class();
            $info = $object->info();

            $plugin = self::instance($plugin_folder);

            $plugin->path = $plugin_folder;

            if (isset($info["name"])) {
                $plugin->name = $info["name"];
            }

            if (isset($info["description"])) {
                $plugin->description = $info["description"];
            }

            if (isset($info["version"])) {
                $plugin->version = $info["version"];
            }

            if (isset($info["author"])) {
                $plugin->author = $info["author"];
            }

            if (isset($info["url"])) {
                $plugin->url = $info["url"];
            }

            if (isset($info["icon"])) {
                $plugin->icon = $info["icon"];
            }

            return $plugin;
        }

    }


    /**
     * Create a plugin instance
     * @return Plugin
     */
    public static function instance($plugin_folder)
    {

        $class = $plugin_folder . "Plugin";

        $plugin = new $class();

        $plugin->path = $plugin_folder;
        $plugin->root = MODULES_PATH . "/" . $plugin_folder;
        $plugin->type = "module";
        $plugin->name = basename($plugin_folder);
        $plugin->description = "";
        $plugin->version = "";
        $plugin->author = "";
        $plugin->url = "";
        $plugin->icon = "fa-puzzle-piece";

        return $plugin;

    }

    /**
     * Get installed pathes
     * @return array
     */
    public static function installedPaths()
    {
        return Config::get("admin.modules", []);
    }

}
