<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Closure;

class AuthLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('id') && session()->has('last_login_at')) {
            if (session()->get('last_login_at') != User::find(session()->get('id'))->last_login_at) {
                session()->flush();
                return redirect('login');
            }
            return $next($request);
        }
        session()->flush();
        return redirect('login');
    }
}
