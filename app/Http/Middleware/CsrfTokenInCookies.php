<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class CsrfTokenInCookies
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Cookie::queue(
            'CSRF-TOKEN',
            csrf_token(),
            config('session.lifetime'),
            null,
            null,
            config('session.secure'),
            false
        );

        return $next($request);
    }
}
