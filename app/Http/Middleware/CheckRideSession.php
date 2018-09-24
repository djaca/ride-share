<?php

namespace App\Http\Middleware;

use Closure;

class CheckRideSession
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
        if (!$request->session()->exists('ride')) {
            return redirect()->route('offer.step.one');
        }

        return $next($request);
    }
}
