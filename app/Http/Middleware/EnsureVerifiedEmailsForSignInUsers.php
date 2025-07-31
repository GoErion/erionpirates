<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVerifiedEmailsForSignInUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()){
            return $next($request);
        }
        $user = $request->user();

        if ($user===null || $user->hasVerifiedEmail()) {
            return $next($request);
        }
        return to_route('verification.notice');
    }
}
