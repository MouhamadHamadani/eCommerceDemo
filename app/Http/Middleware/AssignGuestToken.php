<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class AssignGuestToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() && !$request->cookie('guest_token')) {
            $guestToken = Str::uuid()->toString();
            Cookie::queue('guest_token', $guestToken, 60 * 24 * 30); // Store for 30 days
        }

        return $next($request);
    }
}
