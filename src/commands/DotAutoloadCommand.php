<?php

use Illuminate\Console\Command;

/**
 * Class AutoloadCommand
 */
class DotAutoloadCommand extends Command
{

    /**
     * @var string
     */
    protected $name = 'dot:autoload';

    /**
     * @var string
     */
    protected $description = "Autoload all system classes";

    /**
     *
     */
    public function fire()
    {

        Loader::add(array(
            ADMIN_PATH . "/controllers",
            ADMIN_PATH . "/models",
            ADMIN_PATH . "/middlewares",
            ADMIN_PATH . "/commands"
        ));

        foreach ((array)Config::get("admin.modules") as $module) {

            $module_path = get_module_path($module);

            if ($module_path == "") {
                continue;
            }

            Loader::add(array(
                $module_path . "/controllers",
                $module_path . "/models",
                $module_path . "/middlewares",
                $module_path . "/commands"
            ));

        }

        Loader::register(false);

    }

}