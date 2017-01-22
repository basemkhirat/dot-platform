<?php

use Illuminate\Console\Command;

/**
 * Class ApiDocsGeneratorCommand
 */
class ApiDocsGeneratorCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'dot:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates API Documentation.';

    /**
     * The console command description.
     *
     * @var DocsGenerator
     */

    protected $generator;


    /**
     * ApiDocsGeneratorCommand constructor.
     * @param ApiDocsGenerator $generator
     */
    public function __construct(ApiDocsGenerator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        $this->info('Generating API Documentation.');

        $this->generator->make("api");

        $this->info('API Docs have been generated.');
    }

}
