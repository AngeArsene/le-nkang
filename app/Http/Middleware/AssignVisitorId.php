<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class AssignVisitorId
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $visitorId = $request->cookie('visitor_id');

        if (! is_string($visitorId) || ! Str::isUuid($visitorId)) {
            $visitorId = (string) Str::uuid();
        }

        $request->attributes->set('visitor_id', $visitorId);
        Cookie::queue('visitor_id', $visitorId, 60 * 24 * 365);

        return $next($request);
    }
}
