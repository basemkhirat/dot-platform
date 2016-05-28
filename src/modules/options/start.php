<?php

Navigation::menu("sidebar", function($menu) {

/*    $menu->item('site_options', trans("admin::common.site_options"), URL::to(ADMIN . '/options'))
            ->order(10)
            ->icon("fa-cogs");
*/

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

});

Navigation::menu("topnav", function($menu) {
    $menu->make("options::locales");
});

Navigation::menu("topnav", function($menu) {
    $menu->make("options::dropmenu");
});

Event::listen("post.saved", function($post){
    if($post->post_status == 1){
       // Sitemap::refresh();
    }
});

include __DIR__ . "/routes.php";
