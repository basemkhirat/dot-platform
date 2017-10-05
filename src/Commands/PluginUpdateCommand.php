<?php

namespace Dot\Platform\Commands;

use Dot\Platform\Command;
use Symfony\Component\Console\Input\InputArgument;
use Dot\Platform\Facades\Plugin;

/**
 * Class MigrateCommand
 */
class PluginUpdateCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:update';

    /**
     * @var string
     */
    protected $description = "reinstall a plugin";

    /**
     *
     */
    public function handle()
    {

        $plugin = Plugin::get($this->argument('plugin'));

        if (!$plugin) {
            return $this->error("Plugin " . $this->argument('plugin') . " not found");
        }

        $this->call("plugin:uninstall", [
            "plugin" => $plugin->getKey()
        ]);

        $this->call("plugin:install", [
            "plugin" => $plugin->getKey()
        ]);

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
