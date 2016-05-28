<?php

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // getting all database options
        foreach (Option::all() as $option) {
            Config::set($option->name, $option->value);
        }

        // set the time zone;
        date_default_timezone_set(Config::get("app.timezone"));

        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            App::setLocale(Config::get('app.locale'));
        }

        define("LANG", App::getLocale());
        define("DIRECTION", Config::get("admin.locales")[LANG]["direction"]);

        // getting site status
        if (!$request->is(ADMIN . '/*')) {
            if (!Config::get("site_status")) {
                return view("admin::errors.offline");
            }
        }

        return $next($request);
    }
}
