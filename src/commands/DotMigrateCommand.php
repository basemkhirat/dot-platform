<?php

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class DotMigrateCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'dot:migrate';

    /**
     * @var string
     */
    protected $description = "Migrate all system migration files";


    /**
     *
     */
    public function fire(Container $app)
    {

        $this->info("- Admin");
        $this->call('migrate', [
            '--quiet' => true,
            '--ansi' => true
        ]);

        $this->info("\n");


        foreach (Module::all() as $module => $module_path) {

            $path = str_replace(ROOT_PATH . "/", "", $module_path . "/migrations");

            if (File::exists($path)) {

                $this->info("- " . $module);

                $this->call('migrate', [
                    '--path' => $path,
                    '--quiet' => true
                ]);

                $this->info("\n");
            }

        }

        $this->info("Done.");


    }


}