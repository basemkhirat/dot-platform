<?php

namespace Dot\Platform\Commands;

use Dot\Platform\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MigrateCommand
 */
class PluginEnableCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:enable';

    /**
     * @var string
     */
    protected $description = "Enable a plugin";


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

        if (in_array($plugin, $installed_plugins)) {
            return $this->info("Plugin $plugin is already enabled !");
        }

        $installed_plugins[] = $plugin;

        $plugins = json_encode(array_unique(array_values($installed_plugins)));

        Option::store([
            "plugins" => $plugins
        ]);

        $this->info("Plugin $plugin is enabled successfully");

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

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force overwrite config files', null]
        ];
    }

}
