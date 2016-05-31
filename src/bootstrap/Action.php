<?php

namespace Dot\Platform;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Collection;


/**
 * Class DotAction
 * @package Dot\Platform
 */
class DotAction
{

    /**
     * @var array
     */
    public static $actions = [];

    /**
     * @var
     */
    public static $action;

    /**
     * @param $sidebar
     * @return array
     * get ordered widgets of a given sidebar
     */
    public static function get($sidebar, $args)
    {

        Event::fire($sidebar . ".action", $args);

        $return = [];
        foreach (self::$actions as $action) {
            if ($action->sidebar == $sidebar) {
                $return[] = $action;
            }
        }

        $actions_collection = new Collection($return);
        $sorted_widgets = $actions_collection->sortBy("order")->toArray();

        return $sorted_widgets;

    }

    /**
     * @param $sidebar
     * @return string
     * Render sidebar widgets
     */
    public static function render($sidebar)
    {

        $args = func_get_args();
        $args = array_splice($args, 1);

        $actions = self::get($sidebar, $args);

        $output_html = "";

        foreach ($actions as $action) {
            array_unshift($args, $action);
            $output_html .= call_user_func_array($action->output, $args);
        }

        return $output_html;

    }

    /**
     * @return array
     * return all widgets of all sidebars
     */
    public static function all()
    {
        return self::$actions;
    }

    /**
     * @param $sidebar
     * @param bool $callback
     * @return Widget
     * Making of widget object
     */
    public static function sidebar($sidebar, $callback = false)
    {

        if ($callback) {
            Event::listen($sidebar . ".action", function () use ($sidebar, $callback) {

                self::$action = new self();

                self::$action->sidebar = $sidebar;
                self::$action->name = "";
                self::$action->order = 0;
                self::$action->output = "";

                if (is_callable($callback)) {
                    self::$action->output = $callback;
                }

                self::$actions[] = self::$action;

            });

        }


    }

    /**
     * @param string $name
     * @return mixed
     * set name of widget if wanted
     */
    function name($name = "")
    {
        self::$action->name = $name;
        return self::$action;

    }

    /**
     * @param int $order
     * @return mixed
     * set order of widget if wanted
     */
    function order($order = 0)
    {
        self::$action->order = $order;
        return self::$action;
    }


    /**
     * @param $callback
     * @return mixed
     * set output of widget (required)
     */
    function set($callback)
    {
        if (is_callable($callback)) {
            self::$action->output = $callback();
        } else {
            self::$action->output = $callback;
        }

    }


}
