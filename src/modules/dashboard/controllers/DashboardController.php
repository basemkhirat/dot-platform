<?php

class DashboardController extends Dot\Controller
{

    public $data = array();
    public $conn = '';


    public function __construct()
    {
        $this->conn = Session::get('conn');
        //DB::connection('mongodb')->enableQueryLog();
    }

    public function index($cat_id = 0)
    {
        $cat_id = (int) Request::get("cat_id");

        $this->data["cat_id"] = $cat_id;

        return View::make("dashboard::show", $this->data);
    }

    public function stats()
    {

        $start = date("Y-m-d H:i:s", strtotime(urldecode(Request::get("start"))));
        $end = date("Y-m-d H:i:s", strtotime(urldecode(Request::get("end"))));

        $cats = Category::with(['postViews', 'postStats'])->where('site', $this->conn)->orderBy('name', 'desc');

        $articlesViews = Post::where('site', LANG)->where('type', 'article');
        $articlesStats = PostStat::whereHas('posts', function ($q) {
            $q->where('site', $this->conn)->where('type', 'article');
        })->select(DB::raw('sum(facebook) as facebook'), DB::raw('sum(twitter) as twitter'), DB::raw('sum(youtube) as youtube'));

        if (Request::has("start")) {
            $cats->whereHas('posts', function ($q) use ($start) {
                $q->where("created_at", ">=", $start);
            });
            $articlesViews->where("created_at", ">=", $start);
            $articlesStats->whereHas('posts', function ($q) use ($start) {
                $q->where("created_at", ">=", $start);
            });
            //$ob4->where("post_created_date", ">=", $start);
        }

        if (Request::has("end")) {
            $cats->whereHas('posts', function ($q) use ($end) {
                $q->where("created_at", "<=", $end);
            });
            $articlesViews->where("created_at", "<=", $end);

            $articlesStats->whereHas('posts', function ($q) use ($end) {
                $q->where("created_at", "<=", $end);
            });
            //$ob4->where("post_created_date", "<=", $end);
        }

        $obj1 = $cats->get();

        $obj2 = 0;
        $obj3 = $articlesStats->first();
//        $article_stats = $ob4->first();

        $stats = array();
        //dd($obj3);
        foreach ($obj1 as $key => $value) {
            $total = (@$value->postViews->first()->total) ? @$value->postViews->first()->total : 0;
            $facebook = (@$value->postStats->first()->facebook) ? @$value->postStats->first()->facebook : 0;
            $twitter = (@$value->postStats->first()->twitter) ? @$value->postStats->first()->twitter : 0;
            $youtube = (@$value->postStats->first()->youtube) ? @$value->postStats->first()->youtube : 0;
            $stats[] = array('cat_name' => $value->name, 'cat_id' => $value->id, 'views' => $total, 'facebook' => $facebook
            , 'twitter' => $twitter, 'youtube' => $youtube);
        }

//        foreach ($cats_stats as $key => $value) {
//            $keyS = $this->search_array($value->cat_name, $stats);
//            if ($keyS || $keyS == '0') {
//                $stats[$keyS]['facebook'] = $value->facebook;
//                $stats[$keyS]['twitter'] = $value->twitter;
//                $stats[$keyS]['youtube'] = $value->youtube;
//            } else {
//                $stats[] = array('cat_name' => $value->cat_name, 'cat_id' => $value->cat_id, 'views' => 0, 'facebook' => $value->facebook, 'twitter' => $value->twitter, 'youtube' => $value->youtube);
//            }
//        }

        $stats[] = array('cat_name' => Lang::get('posts::posts.blog'), 'cat_id' => 'article', 'views' => $obj2, 'facebook' => ($obj3->facebook) ? $obj3->facebook : 0, 'twitter' => ($obj3->twitter) ? $obj3->twitter : 0,
            'youtube' => ($obj3->youtube) ? $obj3->youtube : 0);

        usort($stats, function ($a, $b) {
            return $b['views'] - $a['views'];
        });

        $this->data['stats'] = $stats;

        return View::make("dashboard::stats", $this->data);
    }

    private function search_array($search, $arr)
    {

        foreach ($arr as $key => $value) {
            if ($search == $value['cat_name']) {
                return "$key";
            }
        }
        return false;
    }

}
