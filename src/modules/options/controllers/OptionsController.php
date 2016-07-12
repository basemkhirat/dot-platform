<?php

class OptionsController extends Dot\Controller
{

    protected $data = [];

    function __construct()
    {
        parent::__construct();

        $this->data["all_plugins"] = $plugins = Plugin::all();
        $this->data["active_plugins"] = $active_plugins = Plugin::installed();
        $this->data["available_plugins_count"] = count($plugins) - count($active_plugins);
    }

    function index()
    {


        if (Request::isMethod("post")) {

            $options = Request::except("_token");

            $options["site_status"] = Request::get("site_status", 0);

            if (Request::has("app_locale")) {
                Session::put("locale", Request::get("app_locale"));
            }

            Option::store($options);

            return Redirect::back()
                ->with("message", trans("options::options.events.saved"));
        }
        $this->data["option_page"] = "main";
        return View::make("options::show", $this->data);
    }

    function check_update(){

        $version =  Dot::check();

        if($version){

            Option::store([
                "latest_version" => $version->version
            ]);

            $this->data["version"] = $version->version;
        }else{
            $this->data["version"] = false;
        }

        return View::make("options::update", $this->data);

    }

    function seo()
    {

        if (Request::isMethod("post")) {

            // creating sitemap directory if not exists
            $sitemap_path = Request::get("sitemap_path");
            if (!File::exists($sitemap_path)) {
                File::makeDirectory($sitemap_path, 0777, true, true);
                //Sitemap::refresh();
            }

            $options = Request::except("_token");

            $options["sitemap_status"] = Request::get("sitemap_status", 0);
            $options["sitemap_xml_status"] = Request::get("sitemap_xml_status", 0);
            $options["sitemap_html_status"] = Request::get("sitemap_html_status", 0);
            $options["sitemap_txt_status"] = Request::get("sitemap_txt_status", 0);
            $options["sitemap_ping"] = Request::get("sitemap_ping", 0);
            $options["sitemap_google_ping"] = Request::get("sitemap_google_ping", 0);
            $options["sitemap_bing_ping"] = Request::get("sitemap_bing_ping", 0);
            $options["sitemap_yahoo_ping"] = Request::get("sitemap_yahoo_ping", 0);
            $options["sitemap_ask_ping"] = Request::get("sitemap_ask_ping", 0);

            Option::store($options);

            return Redirect::back()
                ->with("message", trans("options::options.events.saved"));
        }
        $this->data["option_page"] = "seo";
        return View::make("options::seo", $this->data);
    }

    function social()
    {
        if (Request::isMethod("post")) {

            Option::store(Request::except("_token"));

            Cache::forget("breaking_tweets");

            return Redirect::back()
                ->with("message", trans("options::options.events.saved"));
        }
        $this->data["option_page"] = "social";
        return View::make("options::social", $this->data);
    }

    function plugins()
    {
        if (Request::isMethod("post")) {

            $active_plugins = array_keys(Request::get("plugins", []));

            Storage::put("plugins", json_encode($active_plugins));

            return Redirect::back()
                ->with("message", trans("options::options.events.saved"));
        }

        $this->data["option_page"] = "plugins";

        return View::make("options::plugins", $this->data);
    }

    function plugin($name, $status, $step = 1)
    {

        if ($step == 1) {

            $path = PLUGINS_PATH . "/" . $name;

            $class = Dot::getPluginClass($path);

            $installed_plugins = Plugin::installedPaths();

            try {

                if ($status == 1) {

                    $installed_plugins[] = $name;

                } else {

                    if (($key = array_search($name, $installed_plugins)) !== false) {
                        unset($installed_plugins[$key]);
                    }
                }

                // fix removed installed plugins folders
                foreach ($installed_plugins as $key => $plugin) {
                    if (!file_exists(PLUGINS_PATH . "/" . $plugin . "/" . Dot::getPluginClass($plugin) . ".php")) {
                        unset($installed_plugins[$key]);
                    }
                }

            } catch (Exception $error) {
                // exception
            }


            Option::store([
                "plugins" => json_encode(array_unique(array_values($installed_plugins)))
            ]);

            return Redirect::route("admin.plugins.activation", ["name" => $name, "status" => $status, "step" => 2]);


        } elseif ($step == 2) {

            try {

                $plugin = Plugin::get($name);

                if ($status == 1) {
                    // installing
                    $plugin->install();
                } else {
                    // uninstalling
                    $plugin->uninstall();
                }

            } catch (Exception $error) {
                // exception
            }

            if ($status == 1) {
                $message = trans("options::options.events.installed");
            } else {
                $message = trans("options::options.events.uninstalled");
            }

            return Redirect::back()
                ->with("message", $message);
        }

    }

    function media()
    {
        if (Request::isMethod("post")) {

            $options = Request::except("_token");

            $options["media_thumbnails"] = Request::get("media_thumbnails", 0);
            $options["media_cropping"] = Request::get("media_cropping", 0);
            $options["media_watermarking"] = Request::get("media_watermarking", 0);
            $options["s3_status"] = Request::get("s3_status", 0);
            $options["s3_delete_locally"] = Request::get("s3_delete_locally", 0);

            Option::store($options, "media");

            return Redirect::back()
                ->with("message", trans("options::options.events.saved"));
        }
        $this->data["option_page"] = "media";
        return View::make("options::media", $this->data);
    }

}
