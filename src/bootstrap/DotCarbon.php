<?php

use Carbon\Carbon;


/**
 * Class DotCarbon
 */
class DotCarbon extends Carbon{


    /**
     * @return Response
     */
    function ago(){
        return time_ago($this->toDateTimeString());
    }

    function render(){

        $date_format = Config::get("date_format");

        if($date_format == "relative"){

            if(LANG == "ar"){
                return $this->ago();
            }else{
                return $this->diffForHumans();
            }

        }else{
            return date($date_format, strtotime($this->toDateTimeString()));
        }

    }


}