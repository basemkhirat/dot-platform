<?php


class PermissionMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {

        if (!User::access($permission)) {
            App::abort(403, 'Access denied to "' . $permission . '"');
        }

        return $next($request);

    }
}
