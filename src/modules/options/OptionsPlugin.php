<?php

class OptionsPlugin extends Plugin
{

    public $providers = [
        Roumen\Sitemap\SitemapServiceProvider::class
    ];

    public $permissions = [
        "general",
        "seo",
        "media",
        "social",
        "plugins",
    ];

    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => "options",
            "version" => "1.0",
        ];

    }

    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {

            if (Gate::allows("options")) {

                $menu->item('options', trans("admin::common.settings"), "")
                    ->order(9)
                    ->icon("fa-cogs");

                if (Gate::allows("options.general")) {
                    $menu->item('options.main', trans("options::options.main"), URL::to(ADMIN . '/options'))
                        ->icon("fa-sliders");
                }

                if (Gate::allows("options.seo")) {
                    $menu->item('options.seo', trans("options::options.seo"), URL::to(ADMIN . '/options/seo'))
                        ->icon("fa-line-chart");
                }

                if (Gate::allows("options.media")) {
                    $menu->item('options.media', trans("options::options.media"), URL::to(ADMIN . '/options/media'))
                        ->icon("fa-camera");
                }

                if (Gate::allows("options.social")) {
                    $menu->item('options.social', trans("options::options.social"), URL::to(ADMIN . '/options/social'))
                        ->icon("fa-globe");
                }

                if (Gate::allows("options.plugins")) {
                    $menu->item('options.plugins', trans("options::options.plugins"), URL::to(ADMIN . '/options/plugins'))
                        ->icon("fa-puzzle-piece");
                }

            }

        });

        Navigation::menu("topnav", function ($menu) {
            $menu->make("options::locales");
        });


        Navigation::menu("topnav", function ($menu) {
            if (Gate::allows("options.general")) {
                $menu->make("options::dropmenu");
            }
        });


        include __DIR__ . "/routes.php";

    }
}