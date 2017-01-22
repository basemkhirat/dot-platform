<?php

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Facades\Hash;

/**
 * Class DotInstallCommand
 */
class DotUpdateCommand extends Dot\Command
{

    /**
     * @var string
     */
    protected $name = 'dot:update';

    /**
     * @var string
     */
    protected $description = "Updating dotcms files";

    /**
     * @var string
     */
    protected $root;


    /**
     * DotInstallCommand constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->root = dirname(public_path());
    }

    /**
     * @return bool
     */
    public function fire()
    {

        if ($this->option("force")) {

            $this->warn("All dotcms tables will be recreated.");
            $this->warn("All dotcms config file will be overwritten.");


            if (App::environment() == "production") {
                if (!$this->confirm("Executing forced update in production ?")) {
                    return false;
                }
            }
        }

        File::makeDirectory(public_path("admin"), 0775, true, true);
        File::makeDirectory($this->root . "/plugins", 0775, true, true);
        File::makeDirectory(public_path("uploads"), 0777, true, true);
        File::makeDirectory(public_path("sitemaps"), 0777, true, true);
        File::makeDirectory(public_path("modules"), 0775, true, true);
        File::makeDirectory(public_path("plugins"), 0775, true, true);

        $this->setPermission($this->root . "/storage", 0777);
        $this->setPermission($this->root . "/bootstrap/cache", 0777);
        $this->setPermission(public_path("uploads"), 0777);
        $this->setPermission(public_path("sitemaps"), 0777);

        // Publishing admin public and config files

        $this->call("vendor:publish", [
            "--tag" => ["admin.public"],
            "--force" => true
        ]);

        $this->call("vendor:publish", [
            "--tag" => ["admin.config"],
            "--force" => $this->option("force")
        ]);

        $modules = Module::all();

        foreach ($modules as $module) {

            // Exception for core modules
            if(in_array($module->path, ["users", "options"])) {
                $module->doInstall($module->path, "module");
            }else{
                $module->doInstall($module->path, "module", $this->option("force"));
            }

        }

        $this->call("dot:api");

        $this->call('optimize', [
            '--quiet' => true
        ]);

        $this->info("Congratulations, Dot platform is now up to date!");
        $this->info("Platform version: " . Dot::version());

    }

    /**
     * @param $path
     * @param $permission
     */
    function setPermission($path, $permission)
    {
        @chmod($path, $permission);
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
