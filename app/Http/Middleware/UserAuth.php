<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class UserAuth
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
        if(Session::get('user_id') == null){

            Session::flash('message', 'Please login first to access the website!');
            Session::flash('alert-class', 'alert-danger');
            return redirect ('/login');
        }
        return $next($request);
    }
}
