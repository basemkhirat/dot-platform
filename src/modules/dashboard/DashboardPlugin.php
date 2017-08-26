<?php

class DashboardPlugin extends Plugin
{

    function info()
    {

        return [
            "name" => "dashboard",
            "version" => "1.0",
        ];

    }

    function boot()
    {

        Navigation::menu("sidebar", function ($menu) {

            $menu->item('home_dashboard', trans("dashboard::dashboard.dashboard"), URL::to(ADMIN . '/dashboard'))
                ->order(0)
                ->icon("fa-info-circle");

        });


        Action::listen("dashboard.featured", function () {

            $data = [];

            $cat_id = (int)Request::get("cat_id");

            $data["cat_id"] = $cat_id;

            $ob = Post::status("published")->format("post");

            if ($cat_id) {
                $ob->where("categories.id", $cat_id);
            }

            $data["news_count"] = $ob->count();

            $ob = Post::status("published")->format("article");

            if ($cat_id) {
                $ob->where("categories.id", $cat_id);
            }

            $data["articles_count"] = $ob->count();

            $data["users_count"] = User::where("status", 1)->count();
            $data["galleries_count"] = Gallery::count();
            $data["categories_count"] = Category::where("parent", 0)->count();
            $data["tags_count"] = Tag::count();

            $posts_charts = array();

            for ($i = 0; $i <= 8; $i++) {

                $today = time();

                $current_day = $today - $i * 24 * 60 * 60;
                $end_current_day = $current_day + 24 * 60 * 60;

                $e = $i + 1;

                $start_of_day = date("Y-m-d H:i:s", $current_day);
                $end_of_day = date("Y-m-d H:i:s", $end_current_day);

                $ob = Post::status("published")->format("post");

                if ($cat_id) {
                    $ob->where("categories.id", $cat_id);
                }

                $posts_charts[date("Y-m-d", $current_day)] = $ob
                    ->where("created_at", '>', $start_of_day)
                    ->where("created_at", '<', $end_of_day)
                    ->count();
            }

            $data["posts_charts"] = array_reverse($posts_charts);

            return view("dashboard::widgets.featured", $data);

        });

        include __DIR__ . "/routes.php";

    }
}
