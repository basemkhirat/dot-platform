<?php

class DashboardProvider extends Plugin
{

    /**
     * @return array
     */
    function info()
    {

        return [
            "name" => trans("dashboard::dashboard.module"),
            "version" => "1.0",
        ];

    }

    function boot()
    {
        Navigation::menu("sidebar", function ($menu) {


            $menu->item('home_dashboard', trans("dashboard::dashboard.dashboard"), URL::to(ADMIN . '/dashboard'))
                ->order(1)
                ->icon("fa-info-circle");

            $menu->item('dashboard', trans("admin::common.statistics"), "javascript:void(0)")
                ->order(17)
                ->icon("fa-info-circle");

            $menu->item('dashboard.general', trans("admin::common.general_statistics"), URL::to(ADMIN . '/dashboard'));

            if (User::access("categories.stats")) {
                $menu->item('dashboard.general', trans("admin::common.categories_statistics"), URL::to(ADMIN . '/stats'));
            }
        });


        /*
        Widget::sidebar("dashboard.featured", function ($widget) {


            $data = [];

            $cat_id = (int)Request::get("cat_id");

            $data["cat_id"] = $cat_id;


            $ob = Post::status("published")->type("post")->where("site", LANG);
            if ($cat_id) {
                $ob->where("categories.id", $cat_id);
            }
            $data["news_count"] = $ob->count();


            $ob = Post::status("published")->type("article")->where("site", LANG);
            if ($cat_id) {
                $ob->where("categories.id", $cat_id);
            }
            $data["articles_count"] = $ob->count();

            $data["users_count"] = User::where("status", 1)->count();
            $data["galleries_count"] = Gallery::count();
            $data["categories_count"] = Category::where("parent", 0)->count();
            $data["tags_count"] = Tag::where("site", LANG)->count();

            $posts_charts = array();
            for ($i = 0; $i <= 8; $i++) {

                $today = strtotime(date("Y-m-d", time()));
                $current_day = $today - $i * 24 * 60 * 60;
                $end_current_day = $current_day + 24 * 60 * 60;

                $e = $i + 1;
                $start_of_day = new MongoDate($current_day);
                $end_of_day = new MongoDate($end_current_day);

                $ob = Post::status("published")->type("post")->where("site", LANG);
                if ($cat_id) {
                    $ob->where("categories.id", $cat_id);
                }

                $posts_charts[date("Y-m-d", $current_day)] = $ob
                    ->where("date", '>', $start_of_day)
                    ->where("date", '<', $end_of_day)
                    ->count();
            }

            $data["posts_charts"] = array_reverse($posts_charts);

            return view("dashboard::widgets.featured", $data);

        });

        */

        include __DIR__ . "/routes.php";

    }
}