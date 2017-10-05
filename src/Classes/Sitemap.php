<?php

namespace Dot\Platform\Classes;

/**
 * Class DotSitemap
 * @package Dot\Platform
 */
class Sitemap
{

    /**
     * @var array
     */
    public static $items = [];

    /**
     * @var
     */
    public static $item;


    /**
     * @var
     */
    public static $sitemaps = [];

    /**
     * @var
     */
    public static $currentSitemap;


    /**
     * @return array
     */
    public static function maps()
    {
        return array_unique(self::$sitemaps);
    }

    /**
     * @param $sitemap
     * @return array
     */
    public static function get($sitemap)
    {

        Event::fire($sitemap . ".sitemap");

        $return = [];
        foreach (self::$items as $item) {
            if ($item->sitemap == $sitemap) {
                $return[] = $item;
            }
        }

        return $return;
    }

    /**
     * @param $sitemap
     * @return string
     */
    public static function render($sitemap)
    {

        $map = App::make("sitemap");

        $items = self::get($sitemap);
        foreach ($items as $item) {
            $map->add($item->loc, $item->lastmod, $item->priority, $item->changefreq);
        }

        $directory = Config::get("sitemap_path");

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }

        if (Config::get("sitemap_xml_status") == 1) {
            $map->store("xml", $directory . "/" . $sitemap);
        }

        if (Config::get("sitemap_html_status") == 1) {
            $map->store("html", $directory . "/" . $sitemap);
        }

        if (Config::get("sitemap_txt_status") == 1) {
            $map->store("txt", $directory . "/" . $sitemap);
        }

        if (Config::get("sitemap_ping") == 1) {
            self::ping($sitemap);
        }

        Option::where("name", "sitemap_last_update")->update(array("value" => time()));

    }

    /**
     * @return bool
     */
    public static function ping($sitemap)
    {

        $sitemap_url = URL::to(Config::get("sitemap_path") . "/" . $sitemap . ".xml");

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

    /**
     * @param $sitemap
     * @param bool $callback
     */
    public static function set($sitemap, $callback = false)
    {

        self::$sitemaps[] = $sitemap;

        if ($callback) {
            Event::listen($sitemap . ".sitemap", function () use ($sitemap, $callback) {
                if ($callback) {
                    self::$currentSitemap = $sitemap;
                    $callback(new self());
                }
            });
        }
    }

    /**
     * @param string $url
     * @param bool $date
     * @param float $freq
     * @param string $priority
     * @return Map
     */
    function url($url = "", $date = false, $freq = 0.9, $priority = "hourly")
    {

        self::$item = new self();

        self::$item->sitemap = self::$currentSitemap;

        self::$item->loc = $url;

        $this->date($date);
        $this->freq($freq);
        $this->priority($priority);

        self::$items[$url] = self::$item;

        return self::$item;
    }

    /**
     * @param bool $date
     * @return mixed
     */
    function date($date = false)
    {
        self::$item->lastmod = ($date) ? $date : date("Y-m-d H:i:s");
        self::$items[self::$item->loc] = self::$item;
        return self::$item;
    }

    /**
     * @param string $priority
     * @return mixed
     */
    function priority($priority = "0.9")
    {
        self::$item->priority = $priority;
        self::$items[self::$item->loc] = self::$item;
        return self::$item;
    }

    /**
     * @param string $freq
     * @return mixed
     */
    function freq($freq = "hourly")
    {
        self::$item->changefreq = $freq;
        self::$items[self::$item->loc] = self::$item;
        return self::$item;
    }


}
