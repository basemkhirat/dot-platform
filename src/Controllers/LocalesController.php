<?php

namespace Dot\Platform\Controllers;

use Dot\Platform\Controller;
use Illuminate\Support\Facades\Request;

/**
 * Class LocalesController
 * @package Dot\Platform\Controllers
 */
class LocalesController extends Controller
{

    /**
     * Switch between system locales
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
            session()->put('locale', $lang);
        }

        return Request::get("redirect_url") ? redirect(Request::get("redirect_url")) : redirect()->back();
    }

}
