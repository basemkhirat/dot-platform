<?php

/**
 * Class LocalesController
 */
class LocalesController extends BackendController
{

    /**
     * @var array
     */
    public $data = [];


    function index($lang)
    {

        if (in_array($lang, array_keys(Config::get("admin.locales")))) {
            Session::put('locale', $lang);
        }

        return Redirect::back();

    }


}
