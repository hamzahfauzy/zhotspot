<?php

namespace App\Http\Middleware;

use Closure;

class UserExpired
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
        $subscription = auth()->user()->customer->subscription()->orderBy('id','desc')->first();
        if(empty($subscription) || $subscription->status == 0)
            return redirect()->back()->with(['error' => 'Your account is not active. Click <a href="'.route('user.payment.create').'">here</a> to make payment for activate your account.']);

        if($subscription->status == 2)
            return redirect()->back()->with(['error' => 'Your subscription is expired']);

        return $next($request);
    }
}
