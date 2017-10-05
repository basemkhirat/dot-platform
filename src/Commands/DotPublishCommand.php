<?php

namespace Dot\Platform\Commands;

use Dot\Platform\Command;
use Symfony\Component\Console\Input\InputOption;

class DotPublishCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'dot:publish';

    /**
     * @var string
     */
    protected $description = "Publishing public and config files";


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
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

        foreach ($modules as $module) {
            if ($this->option("config")) {
                $this->publish_config($module->path);
            } else if ($this->option("public")) {
                $this->publish_public($module->path);
            } else {
                $this->publish_config($module->path);
                $this->publish_public($module->path);
            }
        }

        return $this->info("All files published successfully");

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
