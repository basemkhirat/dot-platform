<?php

Navigation::menu("sidebar", function($menu) {
//    if (User::access('pages')) {
        $menu->item('pages', trans("admin::common.pages"), URL::to(ADMIN . '/pages'))
                ->order(5.5)
                ->icon("fa-file-text-o");
//    }
});


include __DIR__ . "/routes.php";
