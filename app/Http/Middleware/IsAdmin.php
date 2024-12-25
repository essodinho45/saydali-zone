<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        try {
            if (auth()->user()->category->id == 6 || auth()->user()->category->id == 1 || auth()->user()->category->id == 2) {
                return $next($request);
            }
            return redirect()->route('error403');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
