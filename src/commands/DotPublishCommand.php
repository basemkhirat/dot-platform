<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class PluginPublishCommand
 */
class DotPublishCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'dot:publish';

    /**
     * @var string
     */
    protected $description = "Publishing dotcms public and config files";


    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {

        // Publishing admin public and config files

        if ($this->option("public")) {
            $this->call("vendor:publish", [
                "--tag" => ["admin.public"],
                "--force" => true
            ]);
        }

        if ($this->option("config")) {
            $this->call("vendor:publish", [
                "--tag" => ["admin.config"],
                "--force" => $this->option("force")
            ]);
        }

        $modules = Module::all();

        foreach($modules as $module){
            if ($this->option("config")) {
                $this->publish_config($module->path);
            } else if ($this->option("public")) {
                $this->publish_public($module->path);
            } else {
                $this->publish_config($module->path);
                $this->publish_public($module->path);
            }
        }

        return $this->info("All published successfully");

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