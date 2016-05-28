<?php

Navigation::menu("sidebar", function($menu) {
    if (User::access('groups')) {
        $menu->item('users.groups', trans("groups::groups.groups"), route("admin.groups.show"));
    }
});

include __DIR__ . "/routes.php";
