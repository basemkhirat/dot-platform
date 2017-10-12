<?php

namespace Dot\Platform\Commands;

use Dot\Platform\Command;
use Dot\Platform\Facades\Plugin;
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
    protected $description = "Install plugin by name";

    /**
     *
     */
    public function handle()
    {

        $plugin = Plugin::get($this->argument('plugin'));

        if (!$plugin) {
            return $this->error("Plugin " . $this->argument('plugin') . " not found");
        }

        // Install plugin dependencies

        foreach ($plugin->getRecursiveDependencies() as $sub_plugin) {

            $sub_plugin->install();

            $this->info("Plugin " . $sub_plugin->getKey() . " installed successfully");
        }

        // Install the main plugin

        $plugin->install();

        $this->info("Plugin " . $plugin->getKey() . " installed successfully");

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
