<?php

namespace Dot\Platform\Commands;

use Dot\Platform\Command;
use Dot\Platform\Facades\Plugin;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class PluginUninstallCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:uninstall';

    /**
     * @var string
     */
    protected $description = "Uninstall plugin by name";


    public function handle()
    {

        $plugin = Plugin::get($this->argument('plugin'));

        if (!$plugin) {
            return $this->error("Plugin " . $this->argument('plugin') . " not found");
        }

        // Uninstall the plugin

        $plugin->uninstall($this);

        $this->info("Plugin " . $plugin->getKey() . " uninstalled successfully");

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
