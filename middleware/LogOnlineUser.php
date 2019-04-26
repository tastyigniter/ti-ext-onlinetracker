<?php

namespace Igniter\OnlineTracker\Middleware;

use Closure;

class LogOnlineUser
{
    public function handle($request, Closure $next)
    {
        app('tracker')->boot();

        return $next($request);
    }
}