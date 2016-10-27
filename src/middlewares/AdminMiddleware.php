<?php

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {

        // setting the time zone;
        date_default_timezone_set(Config::get("app.timezone"));

        if (!defined("LANG")) {

            // setting default locale
            try {
                if (session()->has('locale')) {
                    app()->setLocale(session()->get('locale'));
                } else {
                    app()->setLocale(config()->get('app.locale'));
                }
                define("LANG", app()->getLocale());
                define("DIRECTION", config()->get("admin.locales")[LANG]["direction"]);


            } catch (Exception $error) {
                abort(500, "System locales is not configured successfully");
            }

        }

        // getting site status
        if (!$request->is(ADMIN . '/*')) {
            if (!Config::get("site_status")) {
                return response(Config::get("offline_message"));
            }
        }


        return $next($request);
    }
}
