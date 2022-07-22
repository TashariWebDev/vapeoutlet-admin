<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        abort_unless(auth()->user()->hasPermissionTo($permission), 403);
        return $next($request);
    }
}
