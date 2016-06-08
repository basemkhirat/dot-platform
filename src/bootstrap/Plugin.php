<?php

/**
 * Plugin Super class
 */
class Plugin
{
    /**
     * Plugin details
     * @return array
     */
    public function info()
    {

        return [
            "name" => "Plugin",
            "description" => "",
            "version" => "0.1",
            "author" => "",
            "icon" => "fa-puzzle-piece"
        ];

    }

    /**
     * Plugin bootstrap
     * Called in system boot
     */
    public function boot()
    {
        // booted
    }

    /**
     * Plugin install
     * Running plugin migrations and default options
     */
    public function install()
    {
        $plugin = strtolower(rtrim(get_called_class(), "Provider"));

        Artisan::call("plugin:migrate:up", [
            "plugin" => $plugin
        ]);

        Artisan::call("module:migrate:up", [
            "module" => $plugin
        ]);

        Artisan::call("plugin:publish", [
            "plugin" => $plugin
        ]);

        Artisan::call("module:publish", [
            "module" => $plugin
        ]);



    }


    /**
     * Plugin uninstall
     * Rollback plugin installation
     */
    public function uninstall()
    {
        $plugin = strtolower(rtrim(get_called_class(), "Provider"));

        Artisan::call("plugin:migrate:down", [
            "plugin" => $plugin
        ]);

        Artisan::call("module:migrate:down", [
            "module" => $plugin
        ]);
    }


    /**
     * Get all system plugins
     * @return array
     */
    public static function all()
    {
        $plugins = [];

        foreach (glob(PLUGINS_PATH . '/*/plugin.php') as $file) {

            $module_path = dirname($file);

            $folder_name = basename($module_path);

            $plugin = self::get($folder_name);

            if ($plugin->path != "") {
                $plugins[] = $plugin;
            }
        }

        return $plugins;

    }


    /**
     * Get all installed plugins
     * @return array
     */
    public static function installed()
    {
        $plugins = [];

        $installed_plugins = self::installedPaths();

        foreach (glob(PLUGINS_PATH . '/*/plugin.php') as $file) {

            $module_path = dirname($file);

            $folder_name = basename($module_path);

            if (in_array($folder_name, $installed_plugins)) {

                $plugin = self::get($folder_name);

                if ($plugin->path != "") {
                    $plugins[] = $plugin;
                }

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

        $path = PLUGINS_PATH . "/" . $plugin_folder;

        $class = ucfirst($plugin_folder) . "Provider";

        if (!class_exists($class)) {
            include($path . "/plugin.php");
        }

        $installed_plugins = self::installedPaths();

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

            if (in_array($plugin_folder, $installed_plugins)) {
                $plugin->installed = true;
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

        $class = $plugin_folder . "Provider";

        $plugin = new $class();

        $plugin->path = "";
        $plugin->name = "plugin";
        $plugin->description = "";
        $plugin->version = "";
        $plugin->author = "";
        $plugin->url = "";
        $plugin->icon = "fa-puzzle-piece";
        $plugin->installed = false;

        return $plugin;

    }


    /**
     * Get installed pathes
     * @return array
     */
    public static function installedPaths()
    {

        $active_plugins = [];

        if (Config::has("plugins")) {
            $active_plugins = json_decode(Config::get("plugins"));
        }

        return $active_plugins;

    }

}