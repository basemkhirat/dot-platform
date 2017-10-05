<?php

namespace Dot\Platform\Classes;

use Illuminate\Support\Facades\Config;

/**
 * Class DotCarbon
 */
class Carbon extends \Carbon\Carbon
{

    /**
     * @return Response
     */
    function ago()
    {
        return time_ago($this->toDateTimeString());
    }

    function render()
    {

        $date_format = Config::get("date_format");

        if ($date_format == "relative") {

            if (app()->getLocale() == "ar") {
                return $this->ago();
            } else {
                return $this->diffForHumans();
            }

        } else {
            return date($date_format, strtotime($this->toDateTimeString()));
        }

    }


}
