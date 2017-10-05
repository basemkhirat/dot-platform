<?php

namespace Dot\Platform\Commands;

use Dot\Platform\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class PluginDisableCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:disable';

    /**
     * @var string
     */
    protected $description = "Disable a plugin";


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
            return $this->info("Plugin $plugin is already disabled !");
        }

        if (($key = array_search($plugin, $installed_plugins)) !== false) {
            unset($installed_plugins[$key]);
        }

        $plugins = json_encode(array_unique(array_values($installed_plugins)));

        Option::store([
            "plugins" => $plugins
        ]);

        $this->info("Plugin $plugin is disabled successfully");

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
