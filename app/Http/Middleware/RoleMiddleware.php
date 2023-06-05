<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if(!$request->user()->hasRole($role)){
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
