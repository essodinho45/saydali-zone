<?php

namespace App\Http\Middleware;

use Closure;

class VerifiedByAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->email_verified_at != null && !auth()->user()->freezed) {
            return $next($request);
        }
        elseif(auth()->user()->freezed)
            return redirect()->route('freezed.notice');
        return redirect()->route('verification.notice');
    }
}
