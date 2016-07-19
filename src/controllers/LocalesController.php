<?php

namespace Dot;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

/**
 * Class LocalesController
 */
class LocalesController extends \Dot\Controller
{

    function index($lang)
    {

        if (in_array($lang, array_keys(config("admin.locales")))) {
            Session::put('locale', $lang);
        }

        return Redirect::back();

    }

}
