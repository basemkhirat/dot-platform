<?php

Navigation::menu("sidebar", function($menu) {
   // if (User::access('navigation.manage')) {
        $menu->item('options.navigations', trans("admin::common.navigations"), URL::to(ADMIN . '/navigations'))->icon("fa-tasks");
   // }
});

include __DIR__ ."/routes.php";
