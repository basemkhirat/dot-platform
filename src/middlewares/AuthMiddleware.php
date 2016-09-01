<?php

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (Auth::guard($guard)->guest()) {

            if ($request->ajax() || $guard == "api") {

                $response = new \DotResponse();
                return $response->json(NULL, "Authentication error", 401);

            } else {
                return redirect()->route('admin.auth.login')->with("url", Request::url());
            }

        }

        return $next($request);
    }
}
