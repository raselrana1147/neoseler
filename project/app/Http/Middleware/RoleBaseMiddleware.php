<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class RoleBaseMiddleware
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
         if(Auth::guard('admin')->user()->IsMerchant()) {
                 return $next($request);
             }
        return redirect()->route('admin.dashboard')->with('unsuccess',"You don't have access to that section");  
    }
}
