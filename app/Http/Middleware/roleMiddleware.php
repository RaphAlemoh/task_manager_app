<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class roleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ... $roles)
    {
        if ($request->user()->hasAnyRole($roles)) {
            return $next($request);
        }
        foreach($roles as $role){
                if ($request->user()->hasRole($role)) {
                    return $next($request);
                }
                abort(401);
        }
    }
}
