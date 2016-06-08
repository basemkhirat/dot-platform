<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class PluginMigrateUpCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:migrate:up';

    /**
     * @var string
     */
    protected $description = "Make plugin migrations up";


    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function fire()
    {

        $path = PLUGINS_PATH . "/" . trim($this->input->getArgument('plugin')) . "/migrations";

        if (!file_exists($path)) {
            return $this->error("Directory not found " . $path);
        }

        foreach (glob($path . "/*.php") as $file) {

            $class = get_migration_class($file);

            if (!class_exists($class)) {
                require_once($file);
            }

            if (class_exists($class)) {

                $instance = new $class();

                try {
                    if (method_exists($instance, "up")) {
                        $instance->up();
                    }
                } catch (Exception $error) {
                }

                $this->info("Migrated up: ". basename($file));

            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected
    function getArguments()
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of the plugin']
        ];
    }

}
