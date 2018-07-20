<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class checkSessionAdmin
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
        if($request->session()->has('admin_email')){
         return $next($request);
        }
        return redirect()->route('adminLogin')->with('err','Please login to continue!');
    }
}
