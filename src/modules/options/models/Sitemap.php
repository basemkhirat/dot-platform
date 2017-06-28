<?php

class Sitemap {

    /*
     * Update sitemap links
     *
     */
    public static function refresh() {

        if (Config::get("sitemap_status") != 1) {
            return false;
        }

        // create new sitemap object
        $sitemap = App::make("sitemap");

        // add items to the sitemap (url, date, priority, freq)
        $sitemap->add(URL::to("/"), date("Y-m-d H:i:s"), '0.9', 'hourly');

        $posts = Post::where("post_status", 1)->orderBy('post_published_date', 'desc')->take(Config::get("sitemap_limit"))->get();

        // add every post to the sitemap
        foreach ($posts as $post) {
            $sitemap->add(URL::to("details/" . $post->post_slug), $post->post_published_date, '0.9', 'hourly');
        }

        $directory = Config::get("sitemap_path");

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }

        $name = "sitemap";

        if (Config::get("sitemap_xml_status") == 1) {
            $sitemap->store("xml", $directory . "/" . $name);
        }

        if (Config::get("sitemap_html_status") == 1) {
            $sitemap->store("html", $directory . "/" . $name);
        }

        if (Config::get("sitemap_txt_status") == 1) {
            $sitemap->store("txt", $directory . "/" . $name);
        }


        if (Config::get("sitemap_ping") == 1) {
            static::ping();
        }

        Option::where("name", "sitemap_last_update")->update(array("value" => time()));
    }

    /*
     * Ping updated sitemap to search engines
     *
     */

    public static function ping() {

        $sitemap_url = URL::to(Config::get("sitemap_path") . "/sitemap.xml");

        $curl_req = array();
        $urls = array();

        // below are the SEs that we will be pining

        if (Config::get("sitemap_google_ping") == 1) {
            $urls[] = "http://www.google.com/webmasters/tools/ping?sitemap=" . ($sitemap_url);
        }

        if (Config::get("sitemap_bing_ping") == 1) {
            $urls[] = "http://www.bing.com/webmaster/ping.aspx?siteMap=" . ($sitemap_url);
        }

        if (Config::get("sitemap_yahoo_ping") == 1) {
            $urls[] = "http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=YahooDemo&amp;url=" . ($sitemap_url);
        }

        if (Config::get("sitemap_ask_ping") == 1) {
            $urls[] = "http://submissions.ask.com/ping?sitemap=" . ($sitemap_url);
        }

        foreach ($urls as $url) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURL_HTTP_VERSION_1_1, 1);
            $curl_req[] = $curl;
        }

        //initiating multi handler
        $multiHandle = curl_multi_init();

        // adding all the single handler to a multi handler
        foreach ($curl_req as $key => $curl) {
            curl_multi_add_handle($multiHandle, $curl);
        }
        $isactive = null;
        do {
            $multi_curl = curl_multi_exec($multiHandle, $isactive);
        } while ($isactive || $multi_curl == CURLM_CALL_MULTI_PERFORM);

        $success = true;
        foreach ($curl_req as $curlO) {
            if (curl_errno($curlO) != CURLE_OK) {
                $success = false;
            }
        }
        curl_multi_close($multiHandle);
        return $success;
    }

}
