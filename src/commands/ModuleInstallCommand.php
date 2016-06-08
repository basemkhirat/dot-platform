<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

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

        $path = MODULES_PATH . "/" . trim($module) . "/plugin.php";

        if (!file_exists($path)) {
            return $this->error("Module $module not found");
        }

        Module::get($module)->install();

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

}