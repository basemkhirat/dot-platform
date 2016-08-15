<?php

namespace Dot\Platform;

/**
 * Class Dot
 * Dot cms super class
 */
class DotPlatform
{

    const VERSION = '0.0.50';

    /**
     * get all system locales
     * @return array
     */
    public function getLocales()
    {
        $locales = [];

        foreach ((array)$this['config']->get("admin.locales") as $code => $locale) {
            $locales[$code] = [
                "title" => isset($locale["title"]) ? $locale["title"] : $code,
                "direction" => isset($locale["direction"]) ? $locale["direction"] : "ltr"
            ];
        }

        return $locales;
    }


    public function version()
    {
        return $this::VERSION;
    }


    public function current_version()
    {
        return $this::VERSION;
    }

    public function latest_version()
    {

        $objCurl = curl_init();

        curl_setopt($objCurl, CURLOPT_URL, "https://api.bitbucket.org/1.0/repositories/basemkhirat/dot-platform/tags");

        curl_setopt($objCurl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($objCurl);
        $tags = json_decode($response, true);


        $versions = [];

        foreach ($tags as $version => $data) {
            $versions[strtotime($data["utctimestamp"])] = [
                "version" => $version,
                "message" => $data["message"]
            ];
        }

        krsort($versions);


        $vers = [];
        foreach ($versions as $time => $data) {

            $ver = new \stdClass();
            $ver->version = $data["version"];
            $ver->message = $data["message"];
            $ver->timestamp = $time;

            $vers[] = $ver;

        }

        return $vers[0];

    }

    public function check()
    {

        $dot_version = $this->current_version();

        $last = $this->latest_version();

        if (version_compare($last->version, $dot_version, ">")) {
            return $last;
        }

        return false;

    }

    function getPluginClass($path)
    {

        $folder = basename($path);
        return ucfirst(camel_case($folder)) . "Plugin";

    }

    function denied(){
        app()->abort(403, "Access denied");
    }


}