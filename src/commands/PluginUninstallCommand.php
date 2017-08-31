<?php

use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class PluginUninstallCommand extends Dot\Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:uninstall';

    /**
     * @var string
     */
    protected $description = "Uninstall a plugin";


    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function handle()
    {

        $plugin = trim($this->input->getArgument('plugin'));

        $installed_plugins = Plugin::installedPaths();

        $class = Dot::getPluginClass($plugin);

        $path = PLUGINS_PATH . "/" . trim($plugin) . "/" . $class . ".php";

        if (!file_exists($path)) {
            return $this->error("Plugin $plugin not found");
        }

        if (!in_array($plugin, $installed_plugins)) {
            return $this->info("Plugin $plugin is already uninstalled !");
        }

        if (($key = array_search($plugin, $installed_plugins)) !== false) {
            unset($installed_plugins[$key]);
        }

        Plugin::get($plugin)->uninstall();

        $plugins = json_encode(array_unique(array_values($installed_plugins)));

        Option::store([
            "plugins" => $plugins
        ]);

        Config::set("plugins", $plugins);

        $this->info("Plugin $plugin is uninstalled successfully");

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of the plugin']
        ];
    }

}
