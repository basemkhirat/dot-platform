<?php

use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class PluginUpdateCommand extends Dot\Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:update';

    /**
     * @var string
     */
    protected $description = "reinstall a plugin";


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

        $this->call("plugin:uninstall", [
            "plugin" => $plugin
        ]);

        $this->call("plugin:install", [
            "plugin" => $plugin
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