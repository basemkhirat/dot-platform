<?php

namespace Dot\Platform;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Event;


/**
 * Class DotNavigation
 * @package Dot\Platform
 */
class DotNavigation {

    /**
     * @var
     */
    protected $items;
    /**
     * @var array
     */
    protected $waiting_items = [];
    /**
     * @var
     */
    protected $current;
    /**
     * @var
     */
    protected $currentKey;
    /**
     * @var bool
     */
    protected $current_key = false;
    /**
     * @var bool
     */
    protected static $menu = false;
    /**
     * @var array
     */
    protected static $lists = [];
    /**
     * @var string
     */
    protected static $template = "";
    /**
     * @var array
     */
    protected static $langs = [];

    /**
     * Menu constructor.
     */
    public function __construct() {
        $this->current = Request::url();
    }

    /*
     * Shortcut method for create a menu with a callback.
     * This will allow you to do things like fire an even on creation.
     *
     * @param callable $callback Callback to use after the menu creation
     * @return object
     */

    /**
     * @param $menu_name
     * @return Menu
     */
    public static function get($menu_name) {
        $menu = new self();
        self::$menu = $menu_name;
        Event::fire($menu_name . '.build', $menu);
        if ($menu_name == "sidebar") {
            $menu->sortItems();
        } else {
            $template = "";
            foreach (self::$lists as $list) {
                $template .= \View::make($list["name"], $list["data"])->render();
            }
            self::$template = $template;
        }
        return $menu;
    }

    /*
     * Usage: Menu::set("topnav", function($menu){
     *      $menu->make("notification::menu");
     * });
     */

    /**
     * @param $menu
     * @param $callback
     */
    public static function menu($menu, $callback) {
        if ($menu == "sidebar") {
            Event::listen($menu . '.build', function($menu) use ($callback) {
                $callback($menu);
            });
        } elseif ($menu == "topnav") {
            Event::listen($menu . '.build', function($menu) use ($callback) {
                $callback(new self);
            });
        }
    }

    /**
     * @param bool $view
     * @param array $data
     */
    public function make($view = false, $data = []) {
        /* if (count(self::$lists)) {
          $this->currentIndex = count(self::$lists) - 1;
          } else {
          $this->currentIndex = 0;
          } */

        $list = [
            "name" => $view,
            "data" => $data
        ];

        self::$lists[] = $list;
        //return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this|array
     */
    function with($name, $value) {

        return self::$lists;
        /*
         *
          $result = [];
          foreach(self::$lists as $list){
          $item = [];
          $item["name"] = $list["name"];
          $item["data"] = array_merge($list["data"], array($name, $value));
          $result[] = $item;
          }

          self::$lists = $result;
          print_r(self::$lists);

         */
        return $this;
    }

    /*
     * Add a menu item to the item stack
     *
     * @param string $key Dot separated hierarchy
     * @param string $name Text for the anchor
     * @param string $url URL for the anchor
     * @param integer $sort Sorting index for the items
     * @param string $icon URL to use for the icon
     */

    /**
     * @param $key
     * @param $name
     * @param $url
     * @param int $sort
     * @param null $icon
     * @return $this
     */
    public function item($key, $name, $url, $sort = 0, $icon = null) {

        self::$langs[$key] = $name;

        $this->current_key = $key;

        $item = array(
            'key' => $key,
            'name' => $name,
            'url' => $url,
            'sort' => $sort,
            'icon' => $icon,
            'children' => array()
        );

        $children = str_replace('.', '.children.', $key);

        if (strstr($key, ".")) {
            $parent = preg_replace("/\.[^.]+$/", "", $key);
            if (!array_has($this->items, $parent)) {
                array_set($this->waiting_items, $children, $item);
                return $this;
            }
        }

        array_set($this->items, $children, $item);

        if ($url == $this->current) {
            $this->currentKey = $key;
        }

        return $this;
    }

    /**
     * @param int $order
     * @return $this
     */
    public function order($order = 0) {
        if ($this->current_key) {
            $children = str_replace('.', '.children.', $this->current_key);
            if (array_has($this->waiting_items, $children)) {
                array_set($this->waiting_items, $children . ".sort", $order);
            } else {
                array_set($this->items, $children . ".sort", $order);
            }
        }
        return $this;
    }

    /**
     * @param null $icon
     * @return $this
     */
    public function icon($icon = null) {
        if ($this->current_key) {
            $children = str_replace('.', '.children.', $this->current_key);
            if (array_has($this->waiting_items, $children)) {
                array_set($this->waiting_items, $children . ".icon", $icon);
            } else {
                array_set($this->items, $children . ".icon", $icon);
            }
        }
        return $this;
    }

    /**
     * @param $key
     * @return string
     */
    public static function lang($key) {
        return isset(self::$langs[$key]) ? self::$langs[$key] : "-";
    }

    /**
     * @return mixed
     */
    public function items() {
        return $this->items;
    }

    /*
     * Recursive function to loop through items and create a menu
     *
     * @param array $items List of items that need to be rendered
     * @param boolean $level Which level you are currently rendering
     * @return string
     */

    /**
     * @param null $items
     * @param int $level
     * @return string
     */
    public function render($items = null, $level = 1) {

        // [{"key":"home_dashboard","name":"\u0644\u0648\u062d\u0629 \u0627\u0644\u062a\u062d\u0643\u0645","url":"http:\/\/localhost\/dotuae\/public\/backend\/dashboard","sort":1,"icon":"fa-info-circle","children":[]},{"key":"posts__________","name":"\u0627\u0644\u0623\u062e\u0628\u0627\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________","sort":3,"icon":"fa-newspaper-o","children":{"all_news":{"key":"posts__________.all_news","name":"\u0643\u0644 \u0627\u0644\u0623\u062e\u0628\u0627\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/aggregator","sort":0,"icon":null,"children":[]},"all":{"key":"posts__________.all","name":" \u0627\u0644\u0623\u062e\u0628\u0627\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________","sort":0,"icon":null,"children":[]},"11":{"key":"posts__________.11","name":"\u0627\u0644\u0623\u0645\u0627\u0631\u0627\u062a","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?cat_id=11","sort":0,"icon":null,"children":[]},"12":{"key":"posts__________.12","name":"\u0627\u0644\u062e\u0627\u0631\u062c\u064a\u0627\u062a","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?cat_id=12","sort":0,"icon":null,"children":[]},"13":{"key":"posts__________.13","name":"\u0645\u0627\u0644 \u0648\u0623\u0639\u0645\u0627\u0644","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?cat_id=13","sort":0,"icon":null,"children":[]},"14":{"key":"posts__________.14","name":"\u0627\u0644\u0631\u064a\u0627\u0636\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?cat_id=14","sort":0,"icon":null,"children":[]},"15":{"key":"posts__________.15","name":"\u062d\u0648\u0627\u062f\u062b \u0648\u0645\u062d\u0627\u0643\u0645","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?cat_id=15","sort":0,"icon":null,"children":[]},"16":{"key":"posts__________.16","name":"\u0627\u0644\u062d\u064a\u0627\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?cat_id=16","sort":0,"icon":null,"children":[]},"17":{"key":"posts__________.17","name":"\u0641\u0646\u0648\u0646","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?cat_id=17","sort":0,"icon":null,"children":[]},"18":{"key":"posts__________.18","name":"\u0627\u0644\u062b\u0642\u0627\u0641\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?cat_id=18","sort":0,"icon":null,"children":[]},"19":{"key":"posts__________.19","name":"\u0627\u0644\u0645\u0639\u0631\u0641\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?cat_id=19","sort":0,"icon":null,"children":[]},"20":{"key":"posts__________.20","name":"\u0627\u0644\u0631\u0623\u064a","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?cat_id=20","sort":0,"icon":null,"children":[]},"21":{"key":"posts__________.21","name":"\u0645\u0633\u0627\u062d\u0627\u062a \u062d\u0631\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?cat_id=21","sort":0,"icon":null,"children":[]},"celebrities":{"key":"posts__________.celebrities","name":"\u0645\u0634\u0627\u0647\u064a\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?post_type=celebrity","sort":0,"icon":null,"children":[]},"articles":{"key":"posts__________.articles","name":"\u0645\u0642\u0627\u0644\u0627\u062a \u0627\u0644\u0631\u0623\u0649","url":"http:\/\/localhost\/dotuae\/public\/backend\/posts__________?post_type=article","sort":0,"icon":null,"children":[]}}},{"key":"agencies","name":"\u0627\u0644\u0648\u0643\u0627\u0644\u0627\u062a","url":"javascript:void(0)","sort":4,"icon":"fa-th-large","children":{"afp":{"key":"agencies.afp","name":"\u0648\u0643\u0627\u0644\u0629 \u0627\u0644\u0623\u062e\u0628\u0627\u0631 \u0627\u0644\u0641\u0631\u0646\u0633\u064a\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?agency_id=afp","sort":0,"icon":null,"children":{"all":{"key":"agencies.afp.all","name":"\u0642\u0627\u0626\u0645\u0629 \u0627\u0644\u0623\u062e\u0628\u0627\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?agency_id=afp","sort":0,"icon":"fa-th-large","children":[]},"urgents":{"key":"agencies.afp.urgents","name":"\u0639\u0627\u062c\u0644","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=urgents","sort":0,"icon":"fa-th-large","children":[]},"sport":{"key":"agencies.afp.sport","name":"\u0631\u064a\u0627\u0636\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=sport","sort":0,"icon":"fa-th-large","children":[]},"moyen-orient":{"key":"agencies.afp.moyen-orient","name":"\u062f\u0648\u0644\u0649","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=moyen-orient","sort":0,"icon":"fa-th-large","children":[]},"economie":{"key":"agencies.afp.economie","name":"\u0627\u0642\u062a\u0635\u0627\u062f","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=economie","sort":0,"icon":"fa-th-large","children":[]},"international":{"key":"agencies.afp.international","name":"\u0627\u0644\u0634\u0631\u0642 \u0627\u0644\u0623\u0648\u0633\u0637","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=international","sort":0,"icon":"fa-th-large","children":[]},"minaldounia":{"key":"agencies.afp.minaldounia","name":"\u0645\u0646 \u0627\u0644\u062f\u0646\u064a\u0627","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=minaldounia","sort":0,"icon":"fa-th-large","children":[]}}},"efe":{"key":"agencies.efe","name":"\u0648\u0643\u0627\u0644\u0629 \u0627\u0644\u0623\u062e\u0628\u0627\u0631 \u0627\u0644\u0627\u0633\u0628\u0627\u0646\u064a\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?agency_id=efe","sort":0,"icon":null,"children":{"all":{"key":"agencies.efe.all","name":"\u0642\u0627\u0626\u0645\u0629 \u0627\u0644\u0623\u062e\u0628\u0627\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?agency_id=efe","sort":0,"icon":"fa-th-large","children":[]},"reports":{"key":"agencies.efe.reports","name":"\u062a\u0642\u0627\u0631\u064a\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=reports","sort":0,"icon":"fa-th-large","children":[]},"text-general":{"key":"agencies.efe.text-general","name":"\u0623\u062e\u0628\u0627\u0631 \u0639\u0627\u0645\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=text-general","sort":0,"icon":"fa-th-large","children":[]},"infographs":{"key":"agencies.efe.infographs","name":"\u0625\u0646\u0641\u0648\u062c\u0631\u0627\u0641","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=infographs","sort":0,"icon":"fa-th-large","children":[]},"photo-sports":{"key":"agencies.efe.photo-sports","name":"\u0635\u0648\u0631 \u0627\u0644\u0631\u064a\u0627\u0636\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=photo-sports","sort":0,"icon":"fa-th-large","children":[]},"text-sports":{"key":"agencies.efe.text-sports","name":"\u0623\u062e\u0628\u0627\u0631 \u0627\u0644\u0631\u064a\u0627\u0636\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=text-sports","sort":0,"icon":"fa-th-large","children":[]}}},"mena":{"key":"agencies.mena","name":"\u0648\u0643\u0627\u0644\u0629 \u0627\u0644\u0634\u0631\u0642 \u0627\u0644\u0627\u0648\u0633\u0637","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?agency_id=mena","sort":0,"icon":null,"children":{"all":{"key":"agencies.mena.all","name":"\u0642\u0627\u0626\u0645\u0629 \u0627\u0644\u0623\u062e\u0628\u0627\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?agency_id=mena","sort":0,"icon":"fa-th-large","children":[]},"healh":{"key":"agencies.mena.healh","name":"\u0635\u062d\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=healh","sort":0,"icon":"fa-th-large","children":[]},"politics":{"key":"agencies.mena.politics","name":"\u0633\u064a\u0627\u0633\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=politics","sort":0,"icon":"fa-th-large","children":[]},"provinces":{"key":"agencies.mena.provinces","name":"\u0645\u062d\u0627\u0641\u0638\u0627\u062a","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=provinces","sort":0,"icon":"fa-th-large","children":[]},"science":{"key":"agencies.mena.science","name":"\u0639\u0644\u0648\u0645 \u0648 \u062a\u0643\u0646\u0648\u0644\u0648\u062c\u064a\u0627","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=science","sort":0,"icon":"fa-th-large","children":[]},"economy":{"key":"agencies.mena.economy","name":"\u0627\u0642\u062a\u0635\u0627\u062f","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=economy","sort":0,"icon":"fa-th-large","children":[]},"accidents":{"key":"agencies.mena.accidents","name":"\u062d\u0648\u0627\u062f\u062b","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=accidents","sort":0,"icon":"fa-th-large","children":[]},"entertaiment":{"key":"agencies.mena.entertaiment","name":"\u0645\u0646\u0648\u0639\u0627\u062a","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=entertaiment","sort":0,"icon":"fa-th-large","children":[]},"culture":{"key":"agencies.mena.culture","name":"\u062b\u0642\u0627\u0641\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=culture","sort":0,"icon":"fa-th-large","children":[]},"militery":{"key":"agencies.mena.militery","name":"\u0639\u0633\u0643\u0631\u064a","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=militery","sort":0,"icon":"fa-th-large","children":[]}}},"reuters":{"key":"agencies.reuters","name":"\u0631\u0648\u064a\u062a\u0631\u0632","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?agency_id=reuters","sort":0,"icon":null,"children":{"all":{"key":"agencies.reuters.all","name":"\u0642\u0627\u0626\u0645\u0629 \u0627\u0644\u0623\u062e\u0628\u0627\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?agency_id=reuters","sort":0,"icon":"fa-th-large","children":[]},"technology-news":{"key":"agencies.reuters.technology-news","name":"\u0627\u0644\u0639\u0644\u0648\u0645 \u0648 \u0627\u0644\u0628\u064a\u0626\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=technology-news","sort":0,"icon":"fa-th-large","children":[]},"entertainment-news":{"key":"agencies.reuters.entertainment-news","name":"\u0645\u0646\u0648\u0639\u0627\u062a","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=entertainment-news","sort":0,"icon":"fa-th-large","children":[]},"sport-news":{"key":"agencies.reuters.sport-news","name":"\u0623\u062e\u0628\u0627\u0631 \u0627\u0644\u0631\u064a\u0627\u0636\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=sport-news","sort":0,"icon":"fa-th-large","children":[]},"top-news":{"key":"agencies.reuters.top-news","name":"\u0623\u062e\u0628\u0627\u0631 \u0627\u0644\u0634\u0631\u0642 \u0627\u0644\u0623\u0648\u0633\u0637","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=top-news","sort":0,"icon":"fa-th-large","children":[]},"business-news":{"key":"agencies.reuters.business-news","name":"\u0623\u062e\u0628\u0627\u0631 \u0627\u0644\u0623\u0642\u062a\u0635\u0627\u062f","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=business-news","sort":0,"icon":"fa-th-large","children":[]},"world-news":{"key":"agencies.reuters.world-news","name":"\u0623\u062e\u0628\u0627\u0631 \u0639\u0627\u0644\u0645\u064a\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=world-news","sort":0,"icon":"fa-th-large","children":[]},"photo":{"key":"agencies.reuters.photo","name":"\u0635\u0648\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/agency?cat_id=photo","sort":0,"icon":"fa-th-large","children":[]}}}}},{"key":"immediate","name":"\u0639\u0627\u062c\u0644","url":"http:\/\/localhost\/dotuae\/public\/backend\/immediate","sort":4.5,"icon":"fa-thumb-tack","children":[]},{"key":"galleries","name":"\u0627\u0644\u0645\u064a\u062f\u064a\u0627","url":"http:\/\/localhost\/dotuae\/public\/backend\/galleries","sort":5,"icon":"fa-camera","children":[]},{"key":"pages","name":"\u0627\u0644\u0635\u0641\u062d\u0627\u062a","url":"http:\/\/localhost\/dotuae\/public\/backend\/pages","sort":5.5,"icon":"fa-file-text-o","children":[]},{"key":"newsletter","name":"\u0627\u0644\u0642\u0627\u0626\u0645\u0629 \u0627\u0644\u0628\u0631\u064a\u062f\u064a\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/newsletter","sort":6,"icon":"fa-envelope","children":[]},{"key":"shortener","name":"\u0627\u0644\u0631\u0648\u0627\u0628\u0637 \u0627\u0644\u0645\u062e\u062a\u0635\u0631\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/shortener","sort":6.5,"icon":"fa-link","children":[]},{"key":"polls","name":"\u0627\u0644\u0627\u0633\u062a\u0641\u062a\u0627\u0621\u0627\u062a","url":"http:\/\/localhost\/dotuae\/public\/backend\/polls","sort":7,"icon":"fa-bar-chart","children":[]},{"key":"news_options","name":"\u0625\u0639\u062f\u0627\u062f\u0627\u062a \u0627\u0644\u0623\u062e\u0628\u0627\u0631","url":"","sort":8,"icon":"fa-cogs","children":{"categories":{"key":"news_options.categories","name":"\u0627\u0644\u062a\u0635\u0646\u064a\u0641\u0627\u062a","url":"http:\/\/localhost\/dotuae\/public\/backend\/grabber?page=cats","sort":1,"icon":"fa-th-large","children":[]},"tags":{"key":"news_options.tags","name":"\u0627\u0644\u0648\u0633\u0648\u0645","url":"http:\/\/localhost\/dotuae\/public\/backend\/tags","sort":3,"icon":"fa-th-large","children":[]},"comments":{"key":"news_options.comments","name":"\u0627\u0644\u062a\u0639\u0644\u064a\u0642\u0627\u062a","url":"http:\/\/localhost\/dotuae\/public\/backend\/comments","sort":5,"icon":"fa-comments","children":[]},"groups":{"key":"news_options.groups","name":"\u0627\u0642\u0631\u0623 \u0627\u0644\u0645\u0632\u064a\u062f","url":"http:\/\/localhost\/dotuae\/public\/backend\/sets","sort":4,"icon":"fa-inbox","children":[]},"topics":{"key":"news_options.topics","name":"\u0627\u0644\u0645\u0648\u0636\u0648\u0639\u0627\u062a","url":"http:\/\/localhost\/dotuae\/public\/backend\/topics","sort":2,"icon":"fa-th-list","children":[]}}},{"key":"options","name":"\u0625\u0639\u062f\u0627\u062f\u0627\u062a \u0627\u0644\u0645\u0648\u0642\u0639","url":"http:\/\/localhost\/dotuae\/public\/backend\/options","sort":9,"icon":"fa-cogs","children":{"main":{"key":"options.main","name":"\u0627\u0644\u0625\u0639\u062f\u0627\u062f\u0627\u062a \u0627\u0644\u0631\u0626\u064a\u0633\u064a\u0629","url":"http:\/\/localhost\/dotuae\/public\/backend\/options","sort":0,"icon":"fa-sliders","children":[]},"seo":{"key":"options.seo","name":"\u0645\u062d\u0631\u0643\u0627\u062a \u0627\u0644\u0628\u062d\u062b","url":"http:\/\/localhost\/dotuae\/public\/backend\/options\/seo","sort":0,"icon":"fa-line-chart","children":[]},"media":{"key":"options.media","name":"\u0627\u0644\u0645\u0644\u062a\u064a\u0645\u062f\u064a\u0627","url":"http:\/\/localhost\/dotuae\/public\/backend\/options\/media","sort":0,"icon":"fa-camera","children":[]},"sources":{"key":"options.sources","name":"\u0625\u0639\u062f\u0627\u062f\u0627\u062a \u0627\u0644\u0645\u0635\u0627\u062f\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/grabber?page=sources","sort":0,"icon":"fa-newspaper-o","children":[]},"mailposts":{"key":"options.mailposts","name":"\u0625\u064a\u0645\u064a\u0644\u0627\u062a \u0627\u0644\u0645\u0631\u0627\u0633\u0644\u064a\u0646","url":"http:\/\/localhost\/dotuae\/public\/backend\/mailposts","sort":0,"icon":"fa-envelope","children":[]}}},{"key":"site_options","name":"\u0625\u062f\u0627\u0631\u0629 \u0627\u0644\u0645\u0648\u0642\u0639","url":"http:\/\/localhost\/dotuae\/public\/backend\/options","sort":10,"icon":"fa-cogs","children":{"mailbox":{"key":"site_options.mailbox","name":"\u0635\u0646\u062f\u0648\u0642 \u0627\u0644\u0628\u0631\u064a\u062f 0\/0","url":"http:\/\/localhost\/dotuae\/public\/backend\/mailbox","sort":5,"icon":"fa-envelope","children":{"inbox":{"key":"site_options.mailbox.inbox","name":"\u0627\u0644\u0648\u0627\u0631\u062f","url":"http:\/\/localhost\/dotuae\/public\/backend\/mailbox","sort":0,"icon":null,"children":[]},"compose":{"key":"site_options.mailbox.compose","name":"\u0625\u0646\u0634\u0627\u0621 \u0628\u0631\u064a\u062f","url":"http:\/\/localhost\/dotuae\/public\/backend\/mailbox\/create","sort":0,"icon":null,"children":[]}}},"tasks":{"key":"site_options.tasks","name":"\u0642\u0627\u0626\u0645\u0629 \u0627\u0644\u0645\u0647\u0627\u0645","url":"http:\/\/localhost\/dotuae\/public\/backend\/tasks","sort":2,"icon":"fa-tasks","children":[]}}},{"key":"users","name":"\u0627\u0644\u0623\u0639\u0636\u0627\u0621","url":"javascript:void(0)","sort":16,"icon":"fa-users","children":{"all":{"key":"users.all","name":"\u0627\u0644\u0623\u0639\u0636\u0627\u0621","url":"http:\/\/localhost\/dotuae\/public\/backend\/users","sort":0,"icon":null,"children":[]},"permissions":{"key":"users.permissions","name":"\u0627\u0644\u0635\u0644\u0627\u062d\u064a\u0627\u062a","url":"http:\/\/localhost\/dotuae\/public\/backend\/roles","sort":0,"icon":null,"children":[]},"authors":{"key":"users.authors","name":"\u0627\u0644\u0645\u0624\u0644\u0641\u064a\u0646","url":"http:\/\/localhost\/dotuae\/public\/backend\/authors","sort":0,"icon":null,"children":[]},"reporters":{"key":"users.reporters","name":"\u0627\u0644\u0645\u062d\u0631\u0631\u064a\u0646","url":"http:\/\/localhost\/dotuae\/public\/backend\/reporters","sort":0,"icon":null,"children":[]},"groups":{"key":"users.groups","name":"\u0645\u062c\u0645\u0648\u0639\u0627\u062a \u0627\u0644\u0623\u0639\u0636\u0627\u0621","url":"http:\/\/localhost\/dotuae\/public\/backend\/groups","sort":0,"icon":null,"children":[]}}},{"key":"dashboard","name":"\u0627\u0644\u0625\u062d\u0635\u0627\u0626\u064a\u0627\u062a","url":"javascript:void(0)","sort":17,"icon":"fa-info-circle","children":{"general":{"key":"dashboard.general","name":"\u0625\u062d\u0635\u0627\u0626\u064a\u0627\u062a \u0627\u0644\u0623\u0642\u0633\u0627\u0645","url":"http:\/\/localhost\/dotuae\/public\/backend\/stats","sort":0,"icon":null,"children":[]},"activities":{"key":"dashboard.activities","name":"\u0625\u062d\u0635\u0627\u0626\u064a\u0627\u062a \u0627\u0644\u0623\u0639\u0636\u0627\u0621","url":"http:\/\/localhost\/dotuae\/public\/backend\/activities","sort":0,"icon":null,"children":[]},"aggregator":{"key":"dashboard.aggregator","name":"\u0625\u062d\u0635\u0627\u0626\u064a\u0627\u062a \u0627\u0644\u0645\u0635\u0627\u062f\u0631","url":"http:\/\/localhost\/dotuae\/public\/backend\/aggregator\/stats","sort":0,"icon":null,"children":[]}}}]

        if (self::$menu == "topnav") {
            return self::$template;
        }

        $items = $items ? : $this->items;

        if ($level <= 2) {
            $attr = 'class="nav nav-second-level collapse level-' . $level.'"';
        } else {
            $attr = 'class="nav nav-third-level collapse level-' . $level.'"';
        }

        $menu = "";

        if ($level != 1) {
            $menu = '<ul ' . $attr . ' >';
        }

        if (count($items)) {
            $level++;

            foreach ($items as $item) {

                $classes = array();
                $classes[] = $this->getActive($item);

                $item['children'] = isset($item['children']) ? $item['children'] : array();

                $has_children = sizeof($item['children']);

                $classes[] = "lev-" . $level;

                //$menu .= '<li' . HTML::attributes(array('class' => implode(' ', $classes))) . '>';

                $menu .= '<li' . ' class = "' . implode(' ', $classes) .' ">';

                $menu .= $this->createAnchor($item, $level, $has_children);

                if ($has_children) {
                    $menu .= $this->render($item['children'], $level);
                }

                $menu .= '</li>';
            }
        } else {
            $level--;
        }

        $menu .= '</ul>';

        return $menu;
    }

    /*
     * Method to render an anchor
     *
     * @param array $item Item that needs to be turned into a link
     * @return string
     */

    /**
     * @param $item
     * @param $level
     * @param $has_children
     * @return string
     */
    private function createAnchor($item, $level, $has_children) {

        if (!isset($item["url"])) {
            $item["url"] = "";
        }

        if (!isset($item["icon"])) {
            $item["icon"] = "";
        }

        if (!isset($item["name"])) {
            $item["name"] = "";
        }

        if (!isset($item["key"])) {
            $item["key"] = "";
        }

        $output = '<a href="' . $item['url'] . '">';
        $output .= $this->createIcon($item);
        if ($level <= 2) {
            $output .= '<span class="nav-label">' . self::lang($item["key"]) . '</span>';
        } else {
            $output .= self::lang($item["key"]);
        }
        if ($has_children) {
            $output .= '<span class="fa arrow"></span>';
        }
        $output .= '</a>';

        return $output;
    }

    /*
     * Method to render an icon
     *
     * @param array $item Item that needs to be turned into a icon
     * @return string
     */

    /**
     * @param $item
     * @return string
     */
    private function createIcon($item) {
        $output = '';

        if (is_array($item['icon'])) {
            $item["icon"] = end($item["icon"]);
        }

        if ($item['icon'] != null) {
            $output .= '<i class="fa ' . $item['icon'] . '"></i>';
        }

        return $output;
    }

    /*
     * Method to sort through the menu items and put them in order
     *
     * @return void
     */

    /**
     * @return array|mixed
     */
    private function sortItems() {
        $this->items = array_merge_recursive($this->items, $this->waiting_items);

        if (Config::has("sidebar") and Config::get("sidebar") != "") {

            // sorting by database

            $orders = Config::get("sidebar");
            $orders = json_decode($orders, true);
            $this->items = $orders;
        } else {

            // sorting by code

            usort($this->items, function($a, $b) {
                if (!isset($a['sort']) or ! isset($b['sort'])) {
                    return 0;
                }
                if ($a['sort'] == $b['sort']) {
                    return 0;
                }
                return ($a['sort'] < $b['sort'] ? -1 : 1);
            });
        }

        return $this->items;
    }

    /**
     * @param $items
     */
    function order_by_db($items) {

        $orders = DB::table("options")->where("name", "sidebar")->pluck("value");
        $orders = json_decode($orders);

        foreach ($items as $item) {
            if (isset($item["key"])) {

            }
        }
    }

    /*
     * Method to find the active links
     *
     * @param array $item Item that needs to be checked if active
     * @return string
     */

    /**
     * @param $item
     * @return string
     */
    private function getActive($item) {
        return "";
        $url = trim($item['url'], '/');

        if ($this->current === $url) {
            return 'active current';
        }

        if (strpos($this->currentKey, $item['key']) === 0) {
            return 'active';
        }
    }

}
