<?php

namespace App\Http\Middleware;

use Closure;

class checkSessionSale
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
        if($request->session()->has('sale_email')){
         return $next($request);
        }
        return redirect()->route('saleLogin')->with('err','Please login to continue!');    }
}
