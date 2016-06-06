<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class PluginMigrateCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:migrate';

    /**
     * @var string
     */
    protected $description = "Migrate plugin migration files";


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

        $path = PLUGINS_PATH . "/" . trim($plugin) . "/migrations";

        if (!file_exists($path)) {
            return $this->error("Directory not found " . $path);
        }

        $this->call("plugin:migrate:down", ["plugin" => $plugin]);
        $this->call("plugin:migrate:up", ["plugin" => $plugin]);
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