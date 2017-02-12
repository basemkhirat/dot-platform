<?php

/**
 * Class DotInstallCommand
 */
class DotInstallCommand extends Dot\Command
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

        $server_errors = [];
        $server_messages = [];

        // check php version
        $minimum_php = '5.5.9';

        if (version_compare(PHP_VERSION, $minimum_php, '>=')) {
            $server_messages[] = "PHP version: " . PHP_VERSION . ".";
        }else{
            $server_errors[] = "Please update your php to $minimum_php current is " . PHP_VERSION . ".";
        }

        // check laravel version
        $minimum_laravel = '5.0';
        $laravel_version = app()->version();

        if (version_compare($laravel_version, $minimum_laravel, '>=')) {
            $server_messages[] = "Laravel version: " . $laravel_version . ".";
        }else{
            $server_errors[] = "You must have laravel $minimum_laravel or higher." . " Current is " . $laravel_version;
        }

        // check mcrypt is installed
        if (!function_exists("mcrypt_encrypt")) {
            $server_errors[] = "PHP mcrypt is not installed.";
        } else {
            $server_messages[] = "PHP mcrypt is installed.";
        }

        // check storage is writable
        if (!is_writable($storage_path = $this->root . "/storage")) {
            $server_errors[] = "Storage path $storage_path is not writable.";
        } else {
            $server_messages[] = "Storage path $storage_path is writable.";
        }


        if (!is_writable($cache_path = $this->root . "/bootstrap/cache")) {
            $server_errors[] = "Cache path $cache_path is not writable";
        } else {
            $server_messages[] = "Cache path $cache_path is writable.";
        }

        if (!is_writable($uploads_path = $this->root . "/public/uploads")) {
            $server_errors[] = "Uploads path $uploads_path is not writable.";
        } else {
            $server_messages[] = "Uploads path $uploads_path is writable.";
        }

        // check Sitemaps path is writable
        if (!is_writable($sitemaps_path = $this->root . "/public/sitemaps")) {
            $server_errors[] = "Sitemaps path $sitemaps_path is not writable.";
        } else {
            $server_messages[] = "Sitemaps path $sitemaps_path is writable.";
        }

        foreach ($server_messages as $message) {
            $this->info($message);
        }

        if (count($server_errors)) {
            foreach ($server_errors as $error) {
                $this->error($error);
            }
            $this->error("Please fix these error(s) before install.");
            return false;
        }

        $this->info("\nInstalling migration files");

        $this->call('dot:migrate', [
            '--quiet' => true
        ]);

        $this->call('vendor:publish', [
            '--quiet' => true
        ]);

        try {

            $this->call("dot:api", [
                '--quiet' => true
            ]);

        }catch (Exception $exception){

            $this->warn($exception->getMessage());

        }

        $this->call('optimize', [
            '--quiet' => true
        ]);

        $this->info("\n");

        $this->call("dot:user", [
            '--quiet' => true,
            '--root'  => true
        ]);

        $this->info("Congratulations, Dot platform ".\Dot\Platform\Facades\Dot::version()." is now installed!");
        $this->info("Navigate to " . admin_url() . " to browse admin interface.");
        $this->info("Enjoy :)");

    }


    /**
     * @param $path
     * @param $permission
     */
    function setPermission($path, $permission)
    {
        @chmod($path, $permission);
    }

}
