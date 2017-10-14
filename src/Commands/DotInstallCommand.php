<?php

namespace Dot\Platform\Commands;

use Dot\Platform\Command;
use Dot\Platform\Facades\Plugin;
use Illuminate\Support\Facades\File;

/**
 * Class DotInstallCommand
 * @package Dot\Platform\Commands
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
    protected $description = "Installing system";

    /**
     * @return bool
     */
    public function handle()
    {

        File::makeDirectory(public_path("uploads"), 0777, true, true);
        File::makeDirectory(public_path("plugins"), 0775, true, true);

        $this->setPermission(base_path("/storage"), 0777);
        $this->setPermission(base_path("/bootstrap/cache"), 0777);
        $this->setPermission(public_path("uploads"), 0777);
        $this->setPermission(public_path("plugins"), 0777);

        $server_errors = [];
        $server_messages = [];

        // Check php version

        $minimum_php = '7.0.0';

        if (version_compare(PHP_VERSION, $minimum_php, '>=')) {
            $server_messages[] = "PHP version: " . PHP_VERSION . ".";
        } else {
            $server_errors[] = "Please update your php to $minimum_php current is " . PHP_VERSION . ".";
        }

        // Check laravel version

        $minimum_laravel = '5.0';
        $laravel_version = app()->version();

        if (version_compare($laravel_version, $minimum_laravel, '>=')) {
            $server_messages[] = "Laravel version: " . $laravel_version . ".";
        } else {
            $server_errors[] = "You must have laravel $minimum_laravel or higher." . " Current is " . $laravel_version;
        }

        // Check mcrypt is installed

        if (!function_exists("mcrypt_encrypt")) {
            $server_errors[] = "PHP mcrypt is not installed.";
        } else {
            $server_messages[] = "PHP mcrypt is installed.";
        }

        // Check storage is writable

        if (!is_writable($storage_path = base_path("storage"))) {
            $server_errors[] = "Storage path $storage_path is not writable.";
        } else {
            $server_messages[] = "Storage path $storage_path is writable.";
        }

        // Check cache is writable

        if (!is_writable($cache_path = base_path("bootstrap/cache"))) {
            $server_errors[] = "Cache path $cache_path is not writable";
        } else {
            $server_messages[] = "Cache path $cache_path is writable.";
        }

        // Check uploads is writable

        if (!is_writable($uploads_path = public_path("uploads"))) {
            $server_errors[] = "Uploads path $uploads_path is not writable.";
        } else {
            $server_messages[] = "Uploads path $uploads_path is writable.";
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

        $this->info("\nInstalling system");

        $this->info("\r");

        $this->call("migrate", [
            '--quiet' => true
        ]);

        foreach (Plugin::all() as $plugin) {
            $plugin->install($this);
        }

        $this->call("dot:user", [
            '--quiet' => true
        ]);

        $this->info("\r");

        $this->info("Congratulations, Dot Platform " . Plugin::get("admin")->getVersion() . " is now installed!");
        $this->info("Navigate to /" . config("admin.prefix") . " to browse the backend.");
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
