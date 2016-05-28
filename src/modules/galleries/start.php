<?php

Navigation::menu("sidebar", function($menu) {
    $menu->item('galleries', trans("admin::common.galleries"), URL::to(ADMIN . '/galleries'))
            ->order(5)
            ->icon("fa-camera");
});

include __DIR__ ."/routes.php";
