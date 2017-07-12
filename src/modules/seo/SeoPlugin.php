<?php

/**
 * Class SeoPlugin
 */
class SeoPlugin extends Plugin
{

    /**
     * Plugin directories
     * @var array
     */
    public $loader = [
        "controllers",
        "models"
    ];

    /**
     * Plugin providers
     * @var array
     */
    public $providers = [];

    /**
     * Plugin aliases
     * @var array
     */
    public $aliases = [];

    /**
     * Plugin commands
     * @var array
     */
    public $commands = [];

    /**
     * Plugin middlewares
     * @var array
     */
    public $middlewares = [];

    /**
     * Plugin route middlwares
     * @var array
     */
    public $route_middlewares = [];

    /**
     * Plugin permissions
     * @var array
     */
    public $permissions = [];

    /**
     * Plugin details
     * @return array
     */
    function info()
    {
        return [
            'name' => 'seo',
            'description' => '',
            'version' => '0.1',
            'icon' => 'fa-puzzle-piece',
            'author' => '',
            'url' => ''
        ];
    }

    /**
     * Plugin bootstrap
     * Called in system boot
     */
    public function boot()
    {

        parent::boot();

        Action::listen("post.form.featured", function ($post) {

            $post->load("seo");

            if ($post->id) {

                $analysis = new Analysis();

                $data['seo_results'] = $analysis->linkdex_output($post);
               // $data['publish_seo'] = $analysis->publish_box();

            } else {

                $analysis = new Analysis();

                $data['seo_results'] = $analysis->linkdex_output($post);
               // $data['publish_seo'] = $analysis->publish_box();

            }

            $data['post'] = $post;

            return view("seo::seo", $data);
        });


        Action::listen("post.saved", function ($post) {

            $meta = Request::get("meta");

            $meta["post_id"] = $post->id;

            SEO::where("post_id", $post->id)->delete();
            SEO::where("post_id", $post->id)->insert($meta);
        });

        include dirname(__FILE__) . "/helpers.php";
        include dirname(__FILE__) . "/routes.php";
    }

    /**
     * Plugin registration
     * Extending core classes
     */
    public function register()
    {
        parent::register();
    }

    /**
     * Plugin install
     * Running plugin migrations and default options
     */
    public function install()
    {
        parent::install();
    }

    /**
     * Plugin uninstall
     * Rollback plugin installation
     */
    public function uninstall()
    {
        parent::uninstall();
    }

}


/**
 * @param $s
 * @return mixed
 */
function string_sanitize($s)
{
    $remove[] = "'";
    $remove[] = '"';
    //$remove[] = "-"; // just as another example

    $result = str_replace($remove, "", $s);
    return $result;
}
