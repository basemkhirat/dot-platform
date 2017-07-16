<?php


class AdminMiddleware
{
    public function handle($request, Closure $next)
    {

        // setting the time zone;

        @date_default_timezone_set(config("app.timezone"));


        // setting default locale

        if (config("admin.locale_driver") == "url") {

            // Getting current locale from the first url segment.

            if (!$request->is(config('admin.prefix') . "/*") and strstr(config("app.url"), $request->header('host'))) {

                if (!array_key_exists($request->segment(1), config('admin.locales'))) {

                    $url = implode('/', $request->segments());

                    if ($request->getQueryString()) {
                        $url .= "?" . $request->getQueryString();
                    }

                    $url = $url ? $url : "/";

                    return redirect(url($url));
                } else {
                    app()->setLocale($request->segment(1));
                }

            }

            app()->setLocale($request->segment(1));
            define("DIRECTION", config()->get("admin.locales")[app()->getLocale()]["direction"]);

        } else {

            // Getting current url from session.

            try {
                if (session()->has('locale')) {
                    app()->setLocale(session()->get('locale'));
                } else {
                    app()->setLocale(config()->get('app.locale'));
                }

                define("DIRECTION", config()->get("admin.locales")[app()->getLocale()]["direction"]);

            } catch (Exception $error) {
                abort(500, "System locales is not configured successfully");
            }

        }

        // Getting frontend status.

        if (!$request->is(ADMIN . '/*')) {
            if (!config("site_status")) {
                return response(config("offline_message"));
            }
        }

        return $next($request);
    }
}
