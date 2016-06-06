<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class PluginInstallCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:install';

    /**
     * @var string
     */
    protected $description = "Install a plugin";


    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function fire()
    {

        $plugin = trim($this->input->getArgument('plugin'));

        $installed_plugins = Plugin::installedPaths();

        $path = PLUGINS_PATH . "/" . trim($plugin) . "/plugin.php";

        if (!file_exists($path)) {
            return $this->error("Plugin $plugin not found");
        }

        if (in_array($plugin, $installed_plugins)) {
            return $this->info("Plugin $plugin is already installed !");
        }

        $installed_plugins[] = $plugin;

        Plugin::get($plugin)->install();

        $plugins = json_encode(array_unique(array_values($installed_plugins)));

        Option::store([
            "plugins" => $plugins
        ]);

        Config::set("plugins", $plugins);

        $this->info("Plugin $plugin is installed successfully");

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