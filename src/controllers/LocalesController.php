<?php

/**
 * Class LocalesController
 */
class LocalesController extends BackendController
{

    function index($lang)
    {

        if (in_array($lang, array_keys(Config::get("admin.locales")))) {
            Session::put('locale', $lang);
        }

        return Redirect::back();

    }

}
