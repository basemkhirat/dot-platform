<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Hash;

/**
 * Class DotInstallCommand
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

        File::makeDirectory($this->root . "/plugins", 0775, true, true);
        File::makeDirectory(public_path("uploads"), 0777, true, true);
        File::makeDirectory(public_path("sitemaps"), 0777, true, true);

        $this->setPermission($this->root . "/storage", 0777);
        $this->setPermission($this->root . "/bootstrap/cache", 0777);
        $this->setPermission(public_path("uploads"), 0777);
        $this->setPermission(public_path("sitemaps"), 0777);

        $server_errors = [];
        $server_messages = [];

        // check php version

        $php_version = phpversion();
        $laravel_version = app()->version();

        if ($php_version < "5.5.9") {
            $server_errors[] = "Please update your php to 5.5.9. Current is " . $php_version;
        } else {
            $server_messages[] = "PHP version: " . $php_version . ".";
        }

        if ($laravel_version < "5.0") {
            $server_errors[] = "You must have laravel 5.0 or higher." . " Current is " . $laravel_version;
        } else {
            $server_messages[] = "Laravel version: " . $laravel_version . ".";
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


        $this->info("Installing migration files");

        $this->call('dot:migrate', [
            '--quiet' => true
        ]);

        $this->call('vendor:publish', [
            '--quiet' => true
        ]);

        $this->call('optimize', [
            '--quiet' => true
        ]);

        $this->info("\n");

        $this->info("Creating Administrator account:");
        $username = $this->ask("Username");
        $password = $this->secret("Password");
        $name = $this->ask("Full name");

        $user = User::where("root", 1)->first();
        $user->username = $username;
        $user->password = $password;
        $user->first_name = $name;
        $user->save();

        $this->info("Congratulations, DOTCMS is now installed!");

        $this->info("Navigate to /" . Config::get("admin.prefix") . " to browse admin interface.");
        $this->info("Don't forget to send your feedback.");

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