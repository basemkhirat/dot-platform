<?php

namespace Dot;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

/**
 * Switching between system locales
 */
class LocalesController extends Controller
{

    function index()
    {

        $lang = Request::get("lang");

        /**
         * Check if localized url is enabled.
         */

        if (config("admin.locale_driver") == "url") {

            $previous_path = str_replace(url("/"), "", url()->previous());

            return Request::get("redirect_url") ? redirect(Request::get("redirect_url")) : redirect($lang . $previous_path);

        }


        if (in_array($lang, array_keys(config("admin.locales")))) {
            Session::put('locale', $lang);
        }

        return Request::get("redirect_url") ? redirect(Request::get("redirect_url")) : redirect()->back();

    }

}
