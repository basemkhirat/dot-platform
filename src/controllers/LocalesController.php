<?php

namespace Dot;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

/**
 * This is the short description
 *
 * This can be an optional longer description of your API call, used within the documentation.
 *
 */
class LocalesController extends Controller
{

    function index($lang)
    {

        if (in_array($lang, array_keys(config("admin.locales")))) {
            Session::put('locale', $lang);
        }

        return Request::get("redirect_url") ? redirect(Request::get("redirect_url")) : redirect()->back();

    }

}
