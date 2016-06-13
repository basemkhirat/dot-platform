<?php

class OptionsPlugin extends Plugin
{

    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => trans("options::options.module"),
            "version" => "1.0",
        ];

    }

    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {

            $menu->item('options', trans("admin::common.settings"), URL::to(ADMIN . '/options'))
                ->order(9)
                ->icon("fa-cogs");

            $menu->item('options.main', trans("options::options.main"), URL::to(ADMIN . '/options'))
                ->icon("fa-sliders");
            $menu->item('options.seo', trans("options::options.seo"), URL::to(ADMIN . '/options/seo'))
                ->icon("fa-line-chart");
            $menu->item('options.media', trans("options::options.media"), URL::to(ADMIN . '/options/media'))
                ->icon("fa-camera");
            $menu->item('options.social', trans("options::options.social"), URL::to(ADMIN . '/options/social'))
                ->icon("fa-globe");

            $menu->item('options.plugins', trans("options::options.plugins"), URL::to(ADMIN . '/options/plugins'))
                ->icon("fa-puzzle-piece");

        });

        Navigation::menu("topnav", function ($menu) {
            $menu->make("options::locales");
        });

        Navigation::menu("topnav", function ($menu) {
            $menu->make("options::dropmenu");
        });

        include __DIR__ . "/routes.php";

    }
}