<?php

use Illuminate\Contracts\Auth\Access\Gate as GateContract;

/**
 * Class AuthMiddleware
 */
class AuthMiddleware
{

    /**
     * AuthMiddleware constructor.
     * @param GateContract $gate
     */
    function __construct(GateContract $gate)
    {
        $this->gate = $gate;
    }

    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $guard = null)
    {

        /**
         * Authenticating
         */

        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $guard == "api") {
                $response = new \DotResponse();
                return $response->json(NULL, "Authentication error", 401);
            } else {
                return redirect()->route('admin.auth.login')->with("url", Request::url());
            }
        }

        /**
         *  Authorizing
         */

        $this->gate->before(function ($user, $permissions) {
            return $user->hasAccess($permissions);
        });


        return $next($request);
    }
}
