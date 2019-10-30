<?php

namespace App\Http\Middleware;

use Closure;

class User
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
        if(auth()->user()->level != 'user')
            return redirect('/dashboard');

        if(empty(auth()->user()->customer))
            return redirect()->route('user.last-step');

        return $next($request);
    }
}
