<?php

namespace Dot\Platform\Controllers;

use Dot\Platform\Controller;
use Illuminate\Http\Request;
use stdClass;

/**
 * Class ServicesController
 */
class ServicesController extends Controller
{

    /**
     * ServicesController constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Getting google search suggestions
     */

    /**
     * @return string
     */
    function keywords(Request $request)
    {

        $q = $request->get("term");

        $keywords = array();
        $data = file_get_contents('http://suggestqueries.google.com/complete/search?output=firefox&client=firefox&hl=ar-EG&q=' . $q);
        if (($data = json_decode($data, true)) !== null) {
            foreach ($data[1] as $item) {
                $keyword = new stdClass();
                $keyword->name = $item;
                $keywords[] = $keyword;
            }
        }

        return response()->json($keywords);
    }

}
