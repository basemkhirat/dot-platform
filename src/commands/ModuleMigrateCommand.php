<?php

use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class ModuleMigrateCommand extends Dot\Command
{

    /**
     * @var string
     */
    protected $name = 'module:migrate';

    /**
     * @var string
     */
    protected $description = "Migrate module migration files";


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

        $path = MODULES_PATH . "/" . trim($module) . "/migrations";

        if (!file_exists($path)) {
            return $this->error("Directory not found " . $path);
        }

        $this->call("module:migrate:down", ["module" => $module]);
        $this->call("module:migrate:up", ["module" => $module]);
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