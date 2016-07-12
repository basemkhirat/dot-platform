<?php

/**
 * Class LocalesController
 */
class LocalesController extends Dot\Controller
{

    function index($lang)
    {

        if (in_array($lang, array_keys(Config::get("admin.locales")))) {
            Session::put('locale', $lang);
        }

        return Redirect::back();

    }

}
