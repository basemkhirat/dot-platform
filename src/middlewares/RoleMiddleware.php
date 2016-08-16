<?php


class RoleMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {

        if (!User::is($role) and !User::is("superadmin")) {
            Dot::forbidden();
        }

        return $next($request);

    }
}
