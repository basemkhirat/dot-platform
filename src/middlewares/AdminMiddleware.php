<?php

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {

        // setting the time zone;
        date_default_timezone_set(Config::get("app.timezone"));

        // setting default locale
        try {
            if (Session::has('locale')) {
                App::setLocale(Session::get('locale'));
            } else {
                App::setLocale(Config::get('app.locale'));
            }
            define("LANG", App::getLocale());
            define("DIRECTION", Config::get("admin.locales")[LANG]["direction"]);
        } catch (Exception $error) {
            abort(500, "System locales is not configured successfully");
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
