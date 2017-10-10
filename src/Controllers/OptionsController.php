<?php

namespace Dot\Platform\Controllers;

use Dot;
use Dot\Platform\Controller;
use Dot\Options\Facades\Option;
use Dot\Platform\Facades\Plugin;
use File;
use Gate;
use Redirect;
use Request;
use Session;
use stdClass;
use View;


/**
 * Class OptionsController
 * @package Dot\Platform\Controllers
 */
class OptionsController extends Controller
{

    /**
     * Check for update
     * @return mixed
     */
    function check_update()
    {

        $current_version = Plugin::get("admin")->getVersion();

        $last_version = $this->get_latest_version()->version;


        if (version_compare($last_version, $current_version, ">")) {
            Option::set("last_platform_version_check", $last_version);
            $this->data["version"] = $last_version;
        } else {
            $this->data["version"] = false;
        }

        return View::make("admin::update", $this->data);
    }


    /**
     * Calling bitbucket API service
     * @return mixed
     */
    public function get_latest_version()
    {

        $objCurl = curl_init();

        curl_setopt($objCurl, CURLOPT_URL, "https://api.bitbucket.org/1.0/repositories/basemkhirat/dot-platform/tags");
        curl_setopt($objCurl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($objCurl);

        $versions = [];

        foreach (json_decode($response, true) as $version => $data) {
            $versions[strtotime($data["utctimestamp"])] = [
                "version" => $version,
                "message" => $data["message"]
            ];
        }

        krsort($versions);

        $vers = [];

        foreach ($versions as $time => $data) {

            $ver = new stdClass();
            $ver->version = $data["version"];
            $ver->message = $data["message"];
            $ver->timestamp = $time;

            $vers[] = $ver;
        }

        return $vers[0];
    }
}
