<?php

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class PluginPublishCommand
 */
class PluginPublishCommand extends Dot\Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:publish';

    /**
     * @var string
     */
    protected $description = "Publishing plugin public and config files";


    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {

        $plugin = trim($this->input->getArgument('plugin'));

        if ($this->option("config")) {

            $this->publish_config($plugin);

        } else if ($this->option("public")) {

            $this->publish_public($plugin);

        } else {

            $this->publish_config($plugin);
            $this->publish_public($plugin);

        }

        return $this->info("Plugin $plugin is published successfully");

    }

    function publish_config($plugin)
    {

        $this->call("vendor:publish", [
            "--tag" => ["$plugin.config"],
            "--force" => $this->option("force")
        ]);

    }

    function publish_public($plugin)
    {

        $this->call("vendor:publish", [
            "--tag" => ["$plugin.public"],
            "--force" => true
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

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['public', null, InputOption::VALUE_NONE, 'Publish module public files', null],
            ['config', null, InputOption::VALUE_NONE, 'Publish module config files', null],
            ['force', null, InputOption::VALUE_NONE, 'Force overwrite config files', null]
        ];
    }

}