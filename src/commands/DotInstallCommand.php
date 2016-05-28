<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class DotInstallCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'dot:install';

    /**
     * @var string
     */
    protected $description = "Migrating, autoloading and publishing dotcms files";

    /**
     *
     */
    public function fire()
    {

        $this->info("Installing migration files");

        $this->call('dot:migrate', [
            '--quiet' => true
        ]);

        $this->call('vendor:publish', [
            '--quiet' => true,
            //'--tag' => ["dot_config", "public"]
        ]);

        $this->call('optimize', [
            '--quiet' => true
        ]);

        $this->info("Dotcms is now installed!");
    }

}