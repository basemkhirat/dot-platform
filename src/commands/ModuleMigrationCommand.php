<?php

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Support\Composer;
use Illuminate\Database\Migrations\MigrationCreator;

class ModuleMigrationCommand extends Dot\Command
{

    protected $signature = 'module:migration {name : The name of the migration.} {module : The name of the module.}
        {--create= : The table to be created.}
        {--table= : The table to migrate.}
        {--path= : The location where the migration file should be created.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration file';


    /**
     * Create a new migration install command instance.
     *
     * @param  \Illuminate\Database\Migrations\MigrationCreator $creator
     * @param  \Illuminate\Support\Composer $composer
     * @return void
     */
    public function __construct(MigrationCreator $creator, Composer $composer)
    {
        parent::__construct();

        $this->creator = $creator;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        // It's possible for the developer to specify the tables to modify in this
        // schema operation. The developer may also specify if this table needs
        // to be freshly created so we can create the appropriate migrations.
        $name = trim($this->input->getArgument('name'));


        $table = $this->input->getOption('table');

        $create = $this->input->getOption('create');

        if (!$table && is_string($create)) {
            $table = $create;
        }

        // Now we are ready to write the migration out to disk. Once we've written
        // the migration out, we will dump-autoload for the entire framework to
        // make sure that the migrations are registered by the class loaders.
        $this->writeMigration($name, $table, $create);

        $this->composer->dumpAutoloads();
    }

    /**
     * Write the migration file to disk.
     *
     * @param  string $name
     * @param  string $table
     * @param  bool $create
     * @return string
     */
    protected function writeMigration($name, $table, $create)
    {


        $module = trim($this->input->getArgument('module'));

        $path = MODULES_PATH . "/" . $module . "/migrations";

        if (!file_exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $file = pathinfo($this->creator->create($name, $path, $table, $create), PATHINFO_FILENAME);

        $this->line("<info>Created Migration:</info> $file");
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the migration'],
            ['module', InputArgument::REQUIRED, 'The name of the module'],
        ];
    }

}
