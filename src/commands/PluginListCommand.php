<?php

use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MigrateCommand
 */
class PluginListCommand extends Dot\Command
{

    /**
     * @var string
     */
    protected $name = 'plugin:list';

    /**
     * @var string
     */
    protected $description = "List all plugins";


    /**
     *
     */
    public function fire()
    {

        $plugins = Plugin::all();
        $installed_count = count(Plugin::installedPaths());

       // dd($installed_count);
        $uninstalled_count = count($plugins) - $installed_count;

        $this->line("");
        $this->info("   All (".count($plugins)."), Installed (". $installed_count."), Uninstalled (". $uninstalled_count .")" );
        $this->line("");
        foreach($plugins as $plugin){

            if($plugin->installed) {
                $this->info(" - " . $plugin->path);
            }else{
                $this->warn(" - " . $plugin->path);
            }

        }

        $this->line("");

    }


}