<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerHistoryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            $permission = Role::where('id',Auth::user()->role)->first();
                if($permission->manage_customer_history  == 'on'){
                    return $next($request);
                }else{
                    return back()->with('error','Access Denied.!!! Please Contact Supper ADMIN.');
                }
            }
    }
}
