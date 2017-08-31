<?php

use Illuminate\Container\Container;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class DotMigrateCommand extends Dot\Command
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
    public function handle(Container $app)
    {

          $admin_migration = glob(ADMIN_PATH . "/migrations/*.php");

          if(count($admin_migration)){

              $this->line("- Admin migrations");

              // Admin
              foreach ($admin_migration as $file) {

                  $class = get_migration_class($file);

                  if (!class_exists($class)) {
                      require_once($file);
                  }

                  if (class_exists($class)) {

                      $instance = new $class();

                      try {
                          if (method_exists($instance, "down")) {
                              $instance->up();
                          }
                      } catch (Exception $error) {

                      }

                      $this->info("Migrated down: ". basename($file));

                      try {
                          if (method_exists($instance, "up")) {
                              $instance->up();
                          }
                      } catch (Exception $error) {

                      }

                      $this->info("Migrated up: ". basename($file));

                  }
              }
        }

        $this->info("\n");

        foreach (Module::all() as $module) {

            if (file_exists(MODULES_PATH . "/" . $module->path . "/migrations")) {

                $this->line("- " . ucfirst($module->path) . " Module");

                $this->call("module:migrate:down", ["module" => $module->path]);
                $this->call("module:migrate:up", ["module" => $module->path]);

                $this->info("\n");
            }

        }

        foreach (Plugin::installed() as $plugin) {

            if (file_exists(PLUGINS_PATH . "/" . $plugin->path . "/migrations")) {

                $this->line("- " . ucfirst($plugin->path) . " Plugin");

                $this->call("plugin:migrate:down", ["plugin" => $plugin->path]);
                $this->call("plugin:migrate:up", ["plugin" => $plugin->path]);

                $this->info("\n");

            }
        }


    }


}
