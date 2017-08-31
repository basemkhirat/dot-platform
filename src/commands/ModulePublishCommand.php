<?php

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ModulePublishCommand
 */
class ModulePublishCommand extends Dot\Command
{

    /**
     * @var string
     */
    protected $name = 'module:publish';

    /**
     * @var string
     */
    protected $description = "Publishing module public and config files";


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $module = trim($this->input->getArgument('module'));

        if ($this->option("config")) {

            $this->publish_config($module);

        } else if ($this->option("public")) {

            $this->publish_public($module);

        } else {

            $this->publish_config($module);
            $this->publish_public($module);

        }

        return $this->info("Module $module is published successfully");

    }

    function publish_config($module)
    {

        $this->call("vendor:publish", [
            "--tag" => ["$module.config"],
            "--force" => $this->option("force")
        ]);

    }

    function publish_public($module)
    {

        $this->call("vendor:publish", [
            "--tag" => ["$module.public"],
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
            ['module', InputArgument::REQUIRED, 'The name of the module']
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
