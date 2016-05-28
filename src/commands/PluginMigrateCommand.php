<?php

use Illuminate\Console\Command;
use Illuminate\Container\Container;
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


    public function __construct(Container $app)
    {
        parent::__construct();
        $this->app = $app;
    }

    /**
     *
     */
    public function fire(Container $app)
    {

        $migrator = $this->app->make('migrator');


        $plugin = trim($this->input->getArgument('plugin'));

        $path = PLUGINS_PATH . "/" . $this->input->getArgument('plugin') . "/migrations";

        if (!file_exists($path)) {
          //  return $this->error("No migrations files found");
        }

        $this->call('migrate', [
            '--path' => str_replace(ROOT_PATH . "/", "", $path)
        ]);

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