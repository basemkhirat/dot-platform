<?php

namespace Dot\Platform;

/**
 * Class DotPlatform
 * Dot cms super class
 * @package Dot\Platform
 */
class DotPlatform
{

    /**
     *  Dot platform version
     */
    const VERSION = '0.2.3;

    /**
     * The current globally available container.
     *
     * @var static
     */
    protected static $instance;

    /**
     * Default system bindings
     * @var array
     */
    public $defaultBindings = [
        "widget" => DotWidget::class,
        "action" => DotAction::class,
        "navigation" => DotNavigation::class,
        "sitemap" => DotSitemap::class,
        "schedule" => DotSchedule::class
    ];

    /**
     * Default instances
     * @var array
     */
    public $instances = [];

    /**
     * DotPlatform constructor.
     */
    function __construct()
    {
        $this->app = app();

        foreach ($this->defaultBindings as $name => $class) {
            $this->instances[$name] = new $class;
        }

    }

    /**
     * Set the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Class Factory
     */
    function loadDotBindings()
    {
        foreach ($this->instances as $name => $instance) {
            $this->app->bind($name, function () use ($instance) {
                return $instance;
            });
        }
    }

    /**
     * @param $name
     * @return null
     */
    function has($name)
    {
        return array_key_exists($name, $this->instances);
    }

    /**
     * @param $name
     * @return null
     */
    function get($name)
    {
        return $this->has($name) ? self::getInstance()->instances[$name] : NULL;
    }

    /**
     * @param $name
     * @param $callback
     */
    function extend($name, $callback)
    {
        self::getInstance()->instances[$name] = $callback($this);
    }

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


    /**
     * @return string
     */
    public function version()
    {
        return $this::VERSION;
    }


    /**
     * @return string
     */
    public function current_version()
    {
        return $this::VERSION;
    }

    /**
     * @return mixed
     */
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

    /**
     * @return bool|mixed
     */
    public function check()
    {
        $dot_version = $this->current_version();

        $last = $this->latest_version();

        if (version_compare($last->version, $dot_version, ">")) {
            return $last;
        }

        return false;
    }

    /**
     * @param $path
     * @return string
     */
    function getPluginClass($path)
    {
        $folder = basename($path);
        return ucfirst(camel_case($folder)) . "Plugin";
    }

    /**
     *
     */
    function forbidden()
    {
        response(view("admin::errors.forbidden")->render(), 403)->send();
        exit();
    }

    /**
     * @param $name
     * @param $arguments
     * @return null
     */
    public  function __call($name, $arguments)
    {
        return self::getInstance()->get($name);
    }


}