<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MigrateCommand
 */
class ModuleInstallCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'module:install';

    /**
     * @var string
     */
    protected $description = "Install a module";


    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function fire()
    {

        $module = trim($this->input->getArgument('module'));

        $class = Dot::getPluginClass($module);

        $path = MODULES_PATH . "/" . trim($module) . "/" . $class . ".php";

        if (!file_exists($path)) {
            return $this->error("Module $module not found");
        }

        Module::get($module)->doInstall($module, "module", $this->option("force"));

        $this->info("Module $module is installed successfully");

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
            ['force', null, InputOption::VALUE_NONE, 'Force overwrite config files', null]
        ];
    }


}