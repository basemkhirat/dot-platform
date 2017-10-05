<?php

namespace Dot\Platform\Commands;

use Dot\Platform\Command;
use Dot\Platform\Facades\Plugin;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class PluginPublishCommand
 */
class PluginPublishCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:publish';

    /**
     * @var string
     */
    protected $description = "Publishing plugin public and config files";


    public function handle()
    {

        $plugin = Plugin::get($this->argument('plugin'));

        if (!$plugin) {
            return $this->error("Plugin " . $this->argument('plugin') . " not found");
        }

        $publish_tags = [
            $plugin->getKey() . ".config",
            $plugin->getKey() . ".public",
            $plugin->getKey() . ".migrations",
            $plugin->getKey() . ".views"
        ];

        if ($this->option("config")) {
            $publish_tags = [$plugin->getKey() . ".config"];
        } else if ($this->option("public")) {
            $publish_tags = [$plugin->getKey() . ".public"];
        } else if ($this->option("migrations")) {
            $publish_tags = [$plugin->getKey() . ".migrations"];
        } else if ($this->option("views")) {
            $publish_tags = [$plugin->getKey() . ".views"];
        }

        $this->call("vendor:publish", [
            "--tag" => $publish_tags,
            "--force" => $this->option("force")
        ]);

        return $this->info("Plugin " . $plugin->getKey() . " published successfully");
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
            ['public', null, InputOption::VALUE_NONE, 'Publish plugin public files', null],
            ['config', null, InputOption::VALUE_NONE, 'Publish plugin config files', null],
            ['migrations', null, InputOption::VALUE_NONE, 'Publish plugin migration files', null],
            ['views', null, InputOption::VALUE_NONE, 'Publish plugin views files', null],
            ['force', null, InputOption::VALUE_NONE, 'Force overwrite config files', null]
        ];
    }

}
