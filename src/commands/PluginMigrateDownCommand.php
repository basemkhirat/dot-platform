<?php

use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class PluginMigrateDownCommand extends Dot\Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:migrate:down';

    /**
     * @var string
     */
    protected $description = "Make plugin migrations down";


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
            return $this->error("Directory not found ". $path);
        }

        foreach (glob($path . "/*.php") as $file) {

            $class = get_migration_class($file);

            if (!class_exists($class)) {
                require_once($file);
            }

            if (class_exists($class)) {

                $instance = new $class();

                try {
                    if (method_exists($instance, "down")) {
                        $instance->down();
                    }
                } catch (Exception $error) {
                }

                $this->info("Migrated down: ". basename($file));

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