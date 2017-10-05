<?php

namespace Dot\Platform\Commands;

use Dot\Platform\Command;
use Dot\Platform\Facades\Plugin;

/**
 * Class MigrateCommand
 */
class PluginListCommand extends Command
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
    public function handle()
    {

        $this->line("");

        $plugins = Plugin::all();

        foreach ($plugins as $plugin) {
            $this->info(" - " . $plugin->getKey());
        }

        $this->line("");
    }


}
