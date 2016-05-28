<?php

/*
 * Add to menu items
 */

Navigation::menu("sidebar", function ($menu) {
    if (User::access('tasks')) {
        $menu->item('site_options.tasks', trans("tasks::tasks.tasks"), route("admin.tasks.show"))
            ->order(2)
            ->icon("fa-tasks");
    }
});

/*
 * Tasks dashboard widget
 */

Widget::sidebar("dashboard.middle", function ($widget) {

    $tasks = Task::join("tasks_users", "tasks.id", "=", "tasks_users.task_id")
        ->where("done", 0)
        ->where("status", 1)
        ->where("tasks_users.user_id", Auth::user()->id)->get();

    return view("tasks::widgets.tasks", ["tasks" => $tasks]);
});



/*
User::method("photo", function($user){
   return $user->hasOne('Media', 'media_id', 'photo_id');
});
*/



/*

Schedule::run(function($schedule){
    //$schedule->exec("rm -Rf /Users/basemkhirat/www/dev/dsagdsgdsgsdagads")->everyMinute();

    $schedule->call(function(){
        sleep(7);
    })->cron('* * * * *')->name("dsafas")->withoutOverlapping();

});

*/

include __DIR__ . "/routes.php";
