<?php

use Illuminate\Support\Facades\Request;

class ServicesController extends \Dot\Controller {

    /**
     * get search results from google
     * @return string
     */
    function keywords() {

        $q = Request::get("term");

        $keywords = array();
        $data = file_get_contents('http://suggestqueries.google.com/complete/search?output=firefox&client=firefox&hl=ar-EG&q=' . $q);

        if (($data = json_decode($data, true)) !== null) {
            foreach ($data[1] as $item) {
                $keyword = new stdClass();
                $keyword->name = $item;
                $keywords[] = $keyword;
            }
        }

        return json_encode($keywords);
    }


}
